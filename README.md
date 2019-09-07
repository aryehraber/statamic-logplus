# Logplus

**Log more things!**

This Addon adds two new ways to use [Statamic’s already great logging functionality](https://docs.statamic.com/debugging#logging).

Not even Chuck Norris himself will be able to stop your logging.

<img src="https://media.giphy.com/media/49HINwAf1JOuI/giphy.gif">

**The Tag **

The `{{ logplus }}` tag allows you to log messages and data directly from your templates, making it easier to debug things, and log potential issues in complex templating scenarios. It can also be used as a simple way to keep an eye on certain pages getting accessed, or query params being used.

**The Controller**

The controller endpoint gives you access to write to the log using JS by submitting a simple `POST` request with a message & optional context data. This can be especially useful when performing some complex JS logic, or connecting to third-party APIs over ajax and logging issues in the `catch` block.

For more details, check out the [docs](https://statamic.com/marketplace/addons/logplus/docs)!

## Examples

### Tag

```blade
{{ logplus message="Just a simple debug message" }}
```

```blade
{{ if slug == "secret-page" }}
  {{ user }}
    {{
      logplus:emergency
      message="🚨 Secret page was accessed!"
      context="url:{ permalink }|user:{ username }"
    }}
  {{ /user }}
{{ /if }}
```

### Controller

```js
axios.post('/!/Logplus/log', { message: 'Just a simple debug message' })
```

```js
axios.post(someExternalEndpoint, {...})
  .then(resp => {
    // success!
  })
  .catch(error => {
    // oh oh
    axios.post('/!/Logplus/log', {
      level: 'critical',
      message: 'Something bad happened',
      context: { data: error.data }
    })
  })
```
