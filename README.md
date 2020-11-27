## Video Share

### Overview
We buy videos from several sources.  Each source provides its content to us in a different format.  
Write a command line script to import the video data into our (imaginary) database.    

Input/output should be something like this:
 
````bash
$ import glorf

importing: "science experiment goes wrong"; Url: http://glorf.com/videos/3; Tags: microwave,cats,peanutbutter
importing: "amazing dog can talk"; Url: http://glorf.com/videos/4; Tags: dog,amazing
````

### Considerations:

- Currently, we are importing videos from 2 sites: flub, and glorf.  They send us their weekly feed via email.  This weeks files are in /feed-exports
- We plan to add a third provider soon who will make their feed available via json output which it will make available via FTP (you don't need to implement this, just keep it mind)
- Do not implement any data persistence code, just provide some dummy classes.  Keep in mind that the company is planning to switch from MySQL to Cassandra in 4 months.
- The focus here should be on design, more than implementation.  We are less interested in seeing that this works than in seeing how you approach the problem.
- Please provide at least some unit tests (it is not required to write them for every class). Functional tests are also a plus.
- Please provide a short summary as SUMMARY.md detailing anything you think is relevant, for example:
  - Where to find your code
  - Was it your first time writing a unit test, using a particular framework, etc?
  - What would you have done differently if you had had more time
  - Etc.

### What we've provided:

We have provided you with a simple dockerized Symfony application, in order to save you time.  You can launch and run 
the whole thing just by running `make`.  This will launch the container and run a simple (failing) test 
that we have prepared.  Feel free to modify the test, or to change or discard anything else that we've provided.
For example, it's not a requirement to use Symfony -- but what we want you to focus on is the problem described above,
and not container or framework boilerplate. 

You can also run:

 - `make provider=glorf import` to import the glorf provider.
 - `make tests` to run both unit and end to end test suites.
 - `make enter` to enter the application container's shell.
 - `make clean` to remove all of the images, containers, and volumes associated with this project.

### Delivery:
Please email your completed test to us as a git bundle.  After committing, simply run 
`git bundle create [your-name].bundle --all`.

*** 

If anything isn't clear, ask us!