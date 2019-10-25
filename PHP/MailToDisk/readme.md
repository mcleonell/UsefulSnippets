# Mail To Disk
Mail to disk is used to simmulate sending a mail on localhost with the mail() function.
The mail will be sent to a text file instead of actually sending it to the email address.

The mail() function is used by PHPMailer.

### How to use

Extract the contents of the [mailtodisk.zip](mailtodisk.zip) file and place it somewhere you can remember, I will place it in C:\mailtodisk.

Now you have to update your php.ini file. You need to find the following line.

```
;sendmail_path =
```

And replace it with

```
sendmail_path = "C:\mailtodisk\mailtodisk.exe"
```

Now the setup is done, let's test if it works. Set up a test server and place this code in a php file.

```php
if(mail('test@mail.invalid', 'Subject', 'Body')) {
    echo 'Mail sent';
}
else {
    echo 'Mail sending failed';
} 
```

Now if you go to the page, it should say "Mail Sent".

Now let's find the output. The output directory's location differs depending on what server you are using.

- wamp server: [PATH TO WAMP]\bin\apache\apache[VERSION NUMBER]\mailoutput
- xampp server: [PATH TO XAMPP]\mailoutput

If you're not using any of these you can try to find "mailoutput" with the search function of your computer.

If everything is setup correctly you should see a text file in the mailoutput directory.

```
To: test@mail.invalid
Subject: Subject

Body
```

#### Enjoy!