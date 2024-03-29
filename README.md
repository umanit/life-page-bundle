# UmanIT - Life Page

This bundle allows you to set up a life page on your site. A certain number of predefines checkers are available and
automatically configured depending on _your_ actual project configuration.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install the extension.

```bash
composer require umanit/life-page-bundle
```

Load the bundle into your Symfony project.

```php
<?php

# config/bundles.php
return [
    // ...
    Umanit\LifePageBundle\UmanitLifePageBundle::class => ['all' => true],
];
```

Import the route file:

```yaml
umanit_life_page:
    resource: '@UmanitLifePageBundle/Resources/config/routing.yaml'
```

Or, if your prefer customize it, adapt the default declaration:

```yaml
umanit_life_page:
    path: /_life/{type}
    controller: umanit_life_page.controller_life_page
    methods: [GET]
    requirements:
        type: '[a-zAZ0-9]+'
    defaults:
        type: all
```

That’s it! Your life page should now be accessible at the path `/_life` and some checks already done if your
configuration meets the requirements.

## Available checkers

The following checkers are available. Each of them are automatically configured if possible, but you can manually use
them if needed.

1. `DoctrineChecker`
2. `PommChecker`
3. `FosElasticaChecker`
4. `SmtpMailerChecker`
5. `SwiftmailerChecker`
6. `MessengerChecker`

### `DoctrineChecker`

Using an entity manager, tries to connect to the database.

#### Automatic configuration

If the service `doctrine.orm.default_entity_manager` exists, a checker is added using it.

### `PommChecker`

Using Pomm, retrieves the default session and tries to get client encoding.

#### Automatic configuration

If the service `pomm.default_session` exists, a checker is added using it.

### `FosElasticaChecker`

Using a client, tries to get the server version.

#### Automatic configuration

If the service `fos_elastica.client.default` exists, a checker is added using it.

### `SmtpMailerChecker`

Using a mailer transport, and only if it’s an instance of `SmtpTransport`, tries to execute a `NOOP` command on the SMTP
server.

#### Automatic configuration

If the service `mailer.default_transport` exists, a checker is added using it.

⚠️ If the service is not an instance of `SmtpTransport`, the checker will be ignored.

### `SwiftmailerChecker`

Using SwiftMailer instance, tries to ping the transport.

#### Automatic configuration

If the service `swiftmailer.mailer.default` exists, a checker is added using it.

### `MessengerChecker`

Using a messenger transport, and only if it’s an instance of `MessageCountAwareInterface`, tries to count available
messages.

#### Automatic configuration

For each service tagged with `messenger.receiver`, a checker will be added.

⚠️ If the service is not an instance of `MessageCountAwareInterface`, the checker will be ignored.

## Adding a custom checker

Create a service which extends the `CheckerInterface` and tag it with `umanit_life_page.service_checker`. Your checker
should now be displayed on the life page.

The method `getName` is used to name the checker on the page while the `check` method is used to determine the status to
display. If it’s `true` then `OK` is shown, if it’s `false` then `KO` is shown and if it’s `null` the checker is
ignored.

## Check only specific services

By adding your own service checker service, you can check only specific services if needed. You need to follow this
steps:

1. Tag some of your services checker with a custom tag ;
2. declare a new service using the class `Umanit\LifePageBundle\Checker\ServiceChecker`
    * The service **must** use a `tagged_iterator` as argument, using your custom tag from the previous step.
    * The service **must** be tag with `umanit_life_page.service_checker_collection` and have a unique `type` value.

**Example:**

 ```xml

<service id="umanit_life_page.critical_services_checker" class="Umanit\LifePageBundle\Checker\ServiceChecker">
    <argument type="tagged_iterator" tag="umanit_life_page.critical_service_checker" />
    <tag name="umanit_life_page.service_checker_collection" type="critical" />
</service>
 ```

Once it’s done you can access to the check using the path `/_life/{type}`, so with our example `/_life/critical`.

The bundle is already providing the `critical` type and all of it’s checker are using it. 

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
