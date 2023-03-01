# Mercure Platform.sh Template

Mercure is an open protocol for real-time communications designed to be fast, reliable and battery-efficient. It is a modern and convenient replacement for both the Websocket API and the higher-level libraries and services relying on it.

Mercure is especially useful to add streaming capabilities to REST and GraphQL APIs. Because it is a thin layer on top of HTTP and SSE, Mercure is natively supported by modern web browsers, mobile applications and IoT devices.

See https://mercure.rocks.

<a href="https://console.platform.sh/projects/create-project/?template=https://github.com/platformsh/mercure-rocks-example&utm_campaign=deploy_on_platform?utm_medium=button&utm_source=affiliate_links&utm_content=https://github.com/platformsh/mercure-rocks-example" target="_blank" title="Deploy with Platform.sh"><img src="https://platform.sh/images/deploy/deploy-button-lg-blue.svg"></a>

Make sure you change in `.platform/applications.yaml`

```
MERCURE_PUBLISHER_JWT_KEY='!ChangeMe!'
MERCURE_SUBSCRIBER_JWT_KEY='!ChangeMe!'
```

You probably also want to disable the demo/ui in:
`mercure/Caddyfile.platform_sh` and possibly allowing anonymous users.


## Copyright

For Mercure: [Kévin Dunglas](https://dunglas.fr), all rights reserved.

# How this example was built:

## Installation
```bash
$MERCURE_VERSION="0.14.0"
wget https://github.com/dunglas/mercure/releases/download/v{$MERCURE_VERSION}/mercure_{$MERCURE_VERSION}_Linux_x86_64.tar.gz
gunzip mercure_{$MERCURE_VERSION}_Linux_x86_64.tar.gz
tar xvf mercure_{$MERCURE_VERSION}_Linux_x86_64.tar
```

## Add mount for DB (you can also use postgres etc..)
`.platform.app.yaml`

```yaml
mounts:
    'db':
        source: local
        source_path: db
```
## Make sure caching are request buffering are off

`.platform/routes.yaml`
```yaml
"https://mercure.{default}/":
    type: upstream
    upstream: "mercure:http"
    cache:
        enabled: false
```

Andin `.platform.app.yaml`

```yaml
        locations:
            /:
                allow: false
                passthru: true
                request_buffering:
                  enabled: false
```

## Configuration (in the `variables.env` section:)

```bash
SERVER_NAME=:$PORT
MERCURE_PUBLISHER_JWT_KEY='!ChangeMe!'
MERCURE_SUBSCRIBER_JWT_KEY='!ChangeMe!'
```

## Start command

```
./mercure run -config Caddyfile.platform_sh
```