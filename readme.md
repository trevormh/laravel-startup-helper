# Laravel Startup Helper
This package helps to reduce repeated tasks during the startup of your laravel app all the way through validation by easily allowing data from your middleware and service providers to be shared with your controllers via a content store. Validation messages can also be dynamically created in your custom validators.

## Example usecases
- Accessing data from middleware in controllers - Example: A vendor may use multiple API keys for different accounts, and each account number is required for processing in the controllers. The authentication process in middleware involves retrieving the account from the database. The controller will have to repeat the same process of querying the account. This package allows the account data to be shared between the middleware and your controllers so that the same query will not have to be repeated again.
- Dynamic validation messages for custom validators - A custom validator can only have a one error message. If a parameter requires multiple conditions to be validated against, a custom validator would have to be created for each validation condition in order to have accurate validation error messages. This package wllows for setting custom error messages within your custom validators.


## Installation

```composer require trevormh/laravel-startup-helper```

## General Usage

First import the package into any php file with:

```
use trevormh\LaravelStartupHelper\StartupFactory; 
```

To access the instance:

```
$helper = StartupFactory::resolve(); 
```

To add content to the store pass an associative array. 

```
$helper->addContent([
    'id' => $id,
    'product' => $product
]);
```

To retrieve from the store you can either pass in a single parameter, or no parameters at all to retrieve the entire store.

```
// retrieve a single property
$id = $helper->get('id');

// retrieve all content
$store = $helper->get();
```

## Custom Validation Messages

If you have custom validators you can create dynamic validation messages from within the validator. To do this in your controller create a validator and pass it to the startup helper

```
$validator = Validator::make($request->all(),[
    'id' => 'integer|SomeCustomValidator'
]);
$helper->addValidator($validator);
```

Next in the custom validator, `SomeCustomValidator`, you can add custom error messages to be passed to the laravel validator

```
Validator::extend('SomeCustomValidator', function($attribute, $value $parameters) {
    $helper = StartupFactory::resolve(); 
    
    $someOtherValue = Model::find('id',$value);

    if ($value !== $someOtherValue->fieldName) {
        $helper->addErrorMessage("id.some_custom_validator", "The id " . $value . " has failed to validate");
        return false;
    }
    // also add the query we just ran
    $helper->addContent['someOtherValue' => $someOtherValue]);
    return true;
});
```

Back in your controller where you called the custom validator from, you can continue validation as you normally would and if there is a validation failure, your custom error message will be set without any additional configuration

```
if ($validator->fails()) {
    $errors = $validator->errors(); // this will contain the error message set in `SomeCustomValidator`
    return $errors; 
}
```

You can also retrieve the data from the query that was executed in `SomeCustomValidator`

```
    $someOtherValue = $helper->get('someOtherValue');
```