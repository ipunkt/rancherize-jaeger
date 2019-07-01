# rancherize-jaeger
jaeger-agent sidekick for rancherize

## Config
### Main Service
When using this plugin a jaeger agent can be added to the project by setting `jaeger.host` to the address and port of
the jaeger collector

#### Example
```json
{
	"default":{
		"jaeger":{
			"host":"jaeger.host.somewhere.com:14250"
		}
	}
}
```
### PHP Command Service
Adding the same jaeger agent for a php-command service can be done by adding `jaeger.host` to the configuration of the
php command in question

#### Example
```json
{
	"default":{
		"php-commands":{
			"rabbitmq-listen":{
				"jaeger":{
					"host":"jaeger.host.somewhere.com:14250"
				}
			}
		}
	}
}
```
