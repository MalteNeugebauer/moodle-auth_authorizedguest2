# Authorized Guest Plugin for Moodle
This authentication plugin allows users to be automatically logged in, if a specific paramter is set in the Moodle URL.
A typical use case is a demo system. If you want to demonstrate some features that would usually require creating an account like attempting a quiz, this plugin allows user  to be automatically logged in with previously created guest accounts. The demonstrator just needs to provide the URL to the quiz and add the trigger paramter to the URL (default: '...&authorizedguest').

## Demo
[This Moodle system](https://moodleresearch.hs-bochum.de) demonstrates the usage of the plugin. The provided links to quizzes on the start page are equipped with the 'authorizedguest' parameter. This serves logging in with guest credentials, allowing users to attempt the quizzes, although not logged in.

## Step by Step Instructions

1. Install the plugin.
1. Enable the plugin under Site Adminstration -> Plugins ->  Authentication -> Manage authentication. It should be chosen as the last option in the auhtentication queue.
1. Create an arbitrary amount of guest user accounts, which can be provided to visitors. If you want to create multiple guest user accounts at the same time, you may want to use Moodle's "Upload Users" function for this step (Site Administration -> Users -> Accounts -> Upload Users).
1. Go to the plugin's settings and store the guest accounts' usersnames and passwords there in the form username;password (username and password separated by a semicolon without spaces, one line per username password combination).
1. Try it out: Create an URL to a page in your Moodle system that would usually require a login and add the plugin's URLS parameter to it (default: authorizedguest). E.g.: https://[moodlesystem].org/my?authorizedguest .
1. When clicking on the link, visitors should be provided with a guest account und see the page.
1. Optional: If you want to provide access to courses or elements in courses this way, you may want to enroll the guest accounts in that course first. Otherwise, the provided content may not be accessible or users have to self-enrol them first. If you have multiple guest accounts, you may want to use the [Mass Enrollments](https://moodle.org/plugins/local_mass_enroll) plugin (local_mass_enroll) for that.

## Video
The following video illustrates how the plugin works.
![Video demonstrating the effect of the plugin](demo_video.gif)

## Contribution
If you want to contribute to this work, please use GitHub's pull requests or issues. You are also welcome to simply write me a mail: malte.neugebauer@hs-bochum.de.

## License
This work is published under the MIT license.