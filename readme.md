------------------
Laravel test
------------------
Please create a user account page.  This page will ask the user for the following fields:
- Name. This is a required field.
- Email.  This should be validated.
- Phone.  This should be validated as numeric only, but auto format the text box to be formatted as (555) 555-1234
- Display Photo.  This should be jpg or png only with a max resolution of 800 x 600
- Interests (checkboxes that are listed from an interest db table).  They should only be able to select 3 interests max, and 1 minimum.

This should hit an AJAX endpoint and do all the necessary Laravel validations.  Validation should also be done via JS prior to submitting to the server.
And also a list page that lists all the users.  This would be guarded using middleware
