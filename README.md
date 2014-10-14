# JWT Server Implementation

Intended to be used in the native DeskPRO app "JWT Auth" app for testing purposes.

## Setup

STEP 1: cd to this directory and execute:

php -S localhost:8003

STEP 2: Add the JWT auth app with the following:

 - Make sure that "Enabled" is checked
 - Secret: deskpro_secret
 - Remote Login URL: http://localhost:8003/jwt_login.php
 - Custom Button Text: "Company XYZ"
 - Agent (or User) Logout Redirect: http://google.com

These values work for this test server. Obviously, these values should change to be whatever values work with your implementation. When you change your secret, you'll need to update the JWT app in your helpdesk. Same with your endpoint, and the logout URL. 

The Custom Button Text is optional, and is only useful if you want to allow the user to click a button to login with JWT (it will simply direct the user to your Remote Login URL with the proper return URL).

## Use

STEP 3: After you install the app, you can use the "TEST" button to test your implementation. If you change settings be sure to save before using the "TEST" button.

STEP 4: Now login to DeskPRO using it. If you enabled automatic SSO, then it will just work. If you use background SSO, it will only work if you are authenticated at the remote site. If you disable SSO you can only authenticate by clicking the "Login with Company XYZ" button.

STEP 5: visiting http://localhost:8003 shows you that you can link back to your helpdesk from within your site, and the SSO rules will just work. Logout of deskpro and head to this url and click on the link that is secured by this JWT server (first, make sure config.php has the right URLs). If automatic SSO is enabled you will be "magically" authenticated, just by clicking that link.

### Valid Logins


| User | Pass  |
|-------|---------|
| cp	| user1 |
| cn	| user2 |
| ct	| user3 |
| user	| user 	|
| admin| admin |

This list is in AuthSystem.php

## Technical Notes

- The DeskPRO system only uses the JWT once, during initial authentication callback. We do not store the JWT and process it on every request. Instead, the normal DeskPRO session takes over after the initial send of the token.

- Your DeskPRO URL must be http://localhost:8888/ for this demo to work fully. Edit config.php if it is not.
