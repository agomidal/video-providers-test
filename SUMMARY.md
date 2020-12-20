# CMP Backend Test Alejandro Gomez
## 1- Explanation
I faced the test trying to achieve high code reusability by making everything depend on abstractions, rather than on implementations.

The ImportCommand uses a VideoProvider class to obtain the videos. The VideoProvider, at the same time, delegates this work to a VideoSourceReader class, which manages the parsing of the source file and its normalization. Then, the VideoProvider loops that and creates the Video entity objects to be persisted.

Lately, the ImportCommand gets an array of configured provider services injected as dependency

``services.yaml``

    App\Command\:
        resource: '../src/Command'
        tags: [ 'console.command' ]
        autowire: true
        # arguments: '@doctrine.orm.entity_manager', [
        arguments: ['doctrineEntityManagerServiceHere', [
        # ADD VIDEO PROVIDER SERVICES AS ARGUMENTS FOR THE VIDEOPROVIDER HERE
            flub: '@providers.flub', 
            glorf: '@providers.glorf'
        ]]

Very little work is required in case you want to add a new provider or change an existing one, be it the format of the source file they send (json,xml,csv,...), the actual format of the content (parsing of the source) or the later normalization (field names which need to be mapped).
The only thing you would have to do in order to modify an existing one is change the corresponding service definition or config.

``config/providers.yaml``
    
    providers:
      flub: 
        source-path: 'tmp/feed-exports/flub.yaml'
      glorf: 
        source-path: 'tmp/feed-exports/glorf.json'

### Sourcereader service configuration sample
``services.yaml``

    source_reader.glorf:
        class: App\Video\SourceReaders\LocalVideoSourceReader
        autowire: false
        arguments:
            - 'glorf'
            - '@App\Config\ConfigurationLoader'
            - '@App\Utils\Parsing\JSONFileParser'
            - '@App\Normalization\Video\GlorfVideoSourceNormalizer'

### VideoProvider service configuration sample
``services.yaml``

    providers.glorf:
        class: App\Video\Providers\VideoProvider
        autowire: false
        arguments:
            - '@source_reader.glorf'

You can find a UML diagram under the design/ directory (methods and class members are missing from the diagram, but it allows to see the idea behind the design).

Overall, the idea is to be able to extend the functionality by adding new providers / parsers / normalizers without modifying the existing code.

## 2- Highlights
Even though the VideoProvider ended being implemented as a configurable service, the idea of implementing a Factory for instantiating the VideoProvider services instead of using dependency injection crossed my mind. We would have a considerably more complex configuration for every provider (remote or local, source file format, normalization mapping, etc) but, this way, we would need to only change the configuration in one place (the providers.yaml config file) and then the factory would parse our settings and create the appropiate object.

A dummy example of how I would implement this can be found under src/Factory.

To be honest, I couldn't tell which one of the approaches would be the more "correct".


## 3- Things to mention
- I had to copy the feed-exports directory inside the app application, because the file wasn't reachable from the container and the parsers where throwing errors.
- I provide unit tests for the ConfigurationLoader class and for the Flurb and Glorf normalizers.
- - To my understanding, functional tests test everything which gets executed during the user interaction with our application (http request, command executed, etc.)
I've seen several examples for functional testing web applications, but none for a Command line app. So, for this functional test, I'm assuming that what I need to test is the whole process and assert that the final output is correct. Forgive me if I'm mistaken and this is not what you were asking for.

## 3- If I've had more time
- More defensive programming here and there to avoid possible errors that I might have overlooked.
- Complete the UML diagram with the methods and members of all classes