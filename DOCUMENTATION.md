## Installation

1. Copy the `Logplus` folder into `site/addons/`.
2. That's it!

**Note:**
If you're planning on using the Controller endpoint, make sure to either submit the CSRF token as part of your request, or whitelist Logplus in `site/settings/system.yaml`:

```
csrf_exclude:
  - '/!/Logplus/*'
```

## Usage

By default, messages will be logged using the `debug` severity level:

### Tag

```blade
{{ logplus message="My debug message" }}
```

### Controller

```js
axios.post('/!/Logplus/log', { message: 'My debug message' })
```

_Log file output_

```
[timestamp] environment.DEBUG: My debug message
```

---

To bump up the severity level, pass in the `level`:

### Tag

Either use the `level` option, or use the shorthand syntax:

```blade
{{ logplus level="error" message="Something bad happened" }}

{{ logplus:error message="Something bad happened" }}
```

### Controller

```js
axios.post('/!/Logplus/log', { level: 'error', message: 'Something bad happened' })
```

_Log file output_

```
[timestamp] environment.ERROR: Something bad happened
```

---

Add additional data by using the `context` option:

### Tag

To pass an array of items, use a pipe-delimited list:

```blade
{{ logplus message="My debug message" context="foo|bar|baz" }}
```

To pass an associative array, use colons to create key/value pairs:

```blade
{{ logplus message="My debug message" context="foo:bar|baz:qux" }}
```

To pass multiple items to a single key, use multiple colons, everything after the first value will be set inside an array:

```blade
{{ logplus message="My debug message" context="data:foo:bar:baz" }}
```

### Controller

To pass an array of items, use an array:

```js
axios.post('/!/Logplus/log', { message: 'My debug message', context: ['foo', 'bar', 'baz'] })
```

To pass an associative array, use an object:

```js
axios.post('/!/Logplus/log', { message: 'My debug message', context: { foo: 'bar', baz: 'qux' } })
```

To pass multiple items to a single key, use an array inside an object:

```js
axios.post('/!/Logplus/log', { message: 'My debug message', context: { data: ['foo', 'bar', 'baz'] } })
```

_Log file output_

```
[timestamp] environment.DEBUG: My debug message ["foo","bar","baz"]
[timestamp] environment.DEBUG: My debug message {"foo":"bar","baz":"qux"}
[timestamp] environment.DEBUG: My debug message {"data":["foo","bar","baz"]}
```

## Parameters

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `level` | String | `debug` | Set the severity level of the log message (available levels: `debug`, `info`, `notice`, `warning`, `error`, `critical`, `alert`, `emergency`). |
| `message` | String | `null` | The message that will be logged. |
| `context` | Array  | `null` | Additional contextual data as an array, associative array or object. |
