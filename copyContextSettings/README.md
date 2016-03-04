# copyContextSettings Snippet

Copies the settings from the context to the specified context (or multiple contexts).

## Usage examples

Basic usage - copies all the settings from the "es" to the "de" context:

```
[[!copyContextSettings? &context=`es` &toContext=`de` ]]
```

... or to multiple contexts:

```
[[!copyContextSettings? &context=`es` &toContext=`de,ru,hu` ]]
```

Copies only specified settings - base_url,cultureKey:

```
[[!copyContextSettings? &context=`es` &toContext=`de` &settings=`base_url,cultureKey` ]]
```

Do not copy settings that exist in the "de" context:

```
[[!copyContextSettings? &context=`es` &toContext=`de` &replace=`0` ]]
```

Remove all the settings in the "de" context before copying:

```
[[!copyContextSettings? &context=`es` &toContext=`de` &clear=`1` ]]
```
