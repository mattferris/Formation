Formation
=========

Formation is a PHP library to help validate form data.

Say you have a form on a webpage.

    <form action="submit.php" method="post">

        <label for="username">Username</label>
        <input type="text" name="username" />

        <label for="password">Password</label>
        <input type="password" name="password" />

        <input type="submit" />

    </form>

To process the submitted form data, write `submit.php` like so.

    <?php

    use \ca\bueller\Formation\Form,
        \ca\bueller\Formation\FormField;

    $form = new Form($_POST);

    $usernameField = new FormField('username', true);
    $passwordField = new FormField('password', true);

    $form->addField($usernameField);
    $form->addField($passwordField);

    if ($form->validate())
    {
        $username = $usernameField->getValue();
        $password = $passwordField->getValue();

        // do more stuff
    }

Form
----

The constructor for `Form` takes an array as it's argument. The array should contain key-value pairs where the keys are the names of the form fields. Typically, passing `$_GET`, `$_POST` or even `$_REQUEST` works best. `FormField`s can be added via `Form::addField()`, which takes an instance of `iFormField` as it's argument. To validate the form, call `Form::validate()`.

    $form = new Form($_POST);
    $form->addField(new FormField('username'));
    if ($form->validate())
    {
        // do stuff
    }

FormField
---------

`FormField`'s constructor has one required argument and two optional arguments. They are *fieldName*, *required* and *validator*. *fieldName* shuold match a key in the array passed to `Form`s constructor. *required* is a boolean value, *true* for required and *false* for not required. *validator* is an instance of `iValidator`.

    $formField = new FormField('name', true); // required field
    $formField = new FormField('nickname'); // not required
    $formField = new FormField('username', true, new RegexValidator('^[a-zA-Z0-9_]$'));
    

Validators
----------

By default, a `FormField` is always valid. If a `FormField` is marked as *required*, then it must not be empty or it won't validate. Further validation can be applied to the field by passing a *validator*. Validators are any object implementing the `iValidator` interface. Formation includes `RegexValidator` which accepts a regex pattern to validate the data against.

    $validator = new RegexValidator('^[a-zA-Z0-9_]$');
    $field = new FormField('username', true, $validator);

Form Events
----------

Calling `Form::validate()` will return `true` or `false`. If you wish to figure out which fields falied to validate, you can listen for `ValidationFailed` events. Subscribing to these events requires registering a handler on the `FormEvents` static class, `FormEvents::registerHandler($handler)`. Registering a handler to collect all the events is easy.

    $errors = array();

    function handleFormErrors ( $event )
    {
        global $errors;
        $fieldName = $event->getField()->getName();
        $errors[] = $fieldName.' failed to validate';
    }

    FormEvents::registerHandler('handleFormErrors');

    // setup form

    if (!$form->validate())
    {
        foreach ($errors as $error)
        {
            echo $error;
        }
    }
