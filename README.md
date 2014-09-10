# ecedi/vars-bundle by [Agence Ecedi](http://ecedi.fr)

this is a simple bundle with no UI, (API only) that replicate CMS like Drupal or Wordpress capacity to store configuration in Database.

## installation

### edit your composer.json file and add

```json
	{
		"require": {
			"ecedi/vars-bundle": "dev-master",
		},
		"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/ecedi/vars-bundle"
		}
		]
	}
```

### Add VarsBundle to your application kernel

```php
	// app/AppKernel.php
	public function registerBundles()
	{
		return array(
			// ...
			new Ecedi\VarsBundle\EcediVarsBundle(),
			// ...
		);
	}
```

### update your schema

```
	app/console doctrine:schema:update --force
```

## Usage

```php
	$vm = $container->get('ecedi.vars.variable_manager'):
	$config = $vm->get('my.parameter', 'default_value');
	$vm->set('my.parameter', 'value');
```