<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Address;
use App\City;
use App\Jobs\SendEmailJob;
use Validator;
use Session;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;


class AdressBookController extends Controller
{

    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $address = Address::all();
        return view('addressbook.index', compact('address'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();

        return View('addressbook.create', compact('cities'));
    }

    /**
     * Validate Data.
     */
    public function storeValidation($request) 
    {
        $rules = array(
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'email'         => 'required|email|unique:address_book',
            'phone'         => 'required|digits:10',
            'zip_code'      => 'required|numeric',
            'city'          => 'required',
            'slug'          => 'required|min:3|max:255|unique:address_book',
            'street'        => 'required',
            'profile_image'         => 'required|image|mimes:jpg,png,jpeg,gif,webp,svg|max:307200|dimensions:width=150,height=150',
        );

        $message = array(
            'image.dimensions'=>'The image dimension must be 150x150'
        );

        $validator = Validator::make($request->all(), $rules, $message);

        return $validator;
           
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->storeValidation($request);

        if ($validator->fails()) {
            return redirect('add-address')
                        ->withErrors($validator)
                        ->withInput();
        }

        $address = new Address();

        $address->first_name    = $request['first_name'];
        $address->last_name     = $request['last_name'];
        $address->email         = $request['email'];
        $address->phone         = $request['phone'];
        $address->zip_code      = $request['zip_code'];
        $address->city          = $request['city'];
        $address->street        = $request['street'];
        $address->slug          = $request['slug'];

        // Check if a profile image has been uploaded
        if ($request->has('profile_image')) {
            // Get image file
            $image = $request->file('profile_image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request['first_name']).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $address->profile_pic = $filePath;
        }

        $address->save();

        //Simple Email.
        $data = array(
            'name'  =>  $request['first_name'],
        );
   
        Mail::send(['html'=>'mail'], $data, function($message) use ($request) {
            $message->to($request['email'], 'Address Book')->subject
                ('Laravel Basic Testing Mail');
            $message->from('admin.addressbook@gmail.com','Test Admin');
        });

        //Send an email after one hour of registration.
        SendEmailJob::dispatch()->delay(now()->addMinutes(60));;

        //Log the information.
        Log::channel('addressbook')->info('Added new address information for address id: '. $address->id);

        Session::flash('success', 'Address Saved Successfully!');

        return redirect('list-address');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $redis = Redis::connection();
        $user = Redis::get('user:profile:'.$slug);
        $address = Address::where('slug',$slug)->first();

        dd($user);

        //Log the activity.
        Log::channel('addressbook')->info('Showing the address information for address id: '.$address['id']);

        //dd($address->City->city);
        return view('addressbook.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $address = Address::where('slug',$slug)->first();
        $cities  = City::all();
        return view('addressbook.edit', compact('address', 'cities'));
    }

    /**
     * Validate Data.
     */
    public function updateValidation($request) 
    {
        $rules = array(
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'email'         => 'required',Rule::unique('address_book', 'email')->ignore($request->email),
            'phone'         => 'required|digits:10',
            'zip_code'      => 'required|numeric',
            'city'          => 'required',
            'slug'          => 'required|min:3|max:255',Rule::unique('address_book', 'slug')->ignore($request->slug),
            'street'        => 'required',
            //'profile_image' => 'required|image|mimes:jpg,png,jpeg,gif,webp,svg|max:307200|dimensions:width=150,height=150',
        );

        $message = array(
            'image.dimensions'=>'The image dimension must be 150x150'
        );

        $validator = Validator::make($request->all(), $rules, $message);

        return $validator;
           
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        /*$validator = $this->updateValidation($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }*/

        $validatedData = $this->validate($request, [
            'first_name'         => 'required|max:255',
            'last_name'          => 'required|max:255',
            'email'              => 'required',Rule::unique('address_book', 'email')->ignore($request->email),
            'phone'              => 'required',
            'zip_code'           => 'required',
            'city'               => 'required',
            'street'             => 'required',
            'slug'               => 'required|unique:address_book,id,' . $address->slug,
          ]);


        // Check if a profile image has been uploaded
        if ($request->has('profile_image')) {
            // Get image file
            $image = $request->file('profile_image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request['first_name']).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            
            $validatedData['profile_pic'] = $filePath;
        }

        $validatedData['slug'] = Str::slug($validatedData['slug'], '-');
        $res = $address->where('id', $request['id'])->update($validatedData);

        //Log the information.
        Log::channel('addressbook')->info('Updated the user address information for address id: '. $request['id']);

        Session::flash('success', 'Address Updated Successfully!');

        return redirect('list-address');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $data = Address::where('slug',$slug)->get();

        Address::where('slug',$slug)->delete();

        //Log the information.
        Log::channel('addressbook')->info('Deleted address information for address id: '. $data->id);

        Session::flash('success', 'Address Deleted Successfully!');

        return redirect('list-address');
    }
}
