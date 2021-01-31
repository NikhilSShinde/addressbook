# addressbook
This is demo application for address book. It contains
1. Task
A tiny version of an address-book should be developed. There should be some
sort of list showing all the entries already made a form to create new entries
and edit existing ones and the possibility to export the list into a XML and CSV
file. Each entry should consist of the fields (first name, last name, profile pic,
email, phone, street, zip-code, and city) where the city should be a drop down,
with cities defined in a table in the database. The design should be user-friendly
and validate all fields as per industry standards. Provide filter (City, Zip code) in
the listing.
Note :
1) Unique Email validation.
2) Real time email validation display.
3) Send email after address book added (Use normal email not smtp).
4) Create Queue and send email after one hour of registration (Any
Promotional email text).
5) Address book listing (Use cache (radis or memcache) & display quick
record using indexing in mysql).
6) Phone number validation required (10 Digit).
7) Use slug or any unique combination to manage (edit, update, delete)
record, don’t use primary ID.
8) Image validation (jpg, png, jpeg, gif, webp, svg), 150 x 150 size allowed
only, not more than 300kb, Server Side as well as client side validation
required.
9) Need each and every record history (Insert, Update, Delete) (LOG)
