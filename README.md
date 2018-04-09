# PHP Logger

Simple logger class to:

* Keep track of log entries.
* Keep track of timings with `time()` and `timeEnd()` methods, Javascript style.
* Optionally write log entries in real-time to file or to screen.
* Optionally dump the log to file in one go at any time.

Log entries can be added with any of the following methods:

* `info( $message, $title )`
* `debug( $message, $title )`
* `warning( $message, $title )`
* `error( $message, $title )`

For example, the following code

```php
Logger::info( "an informational message intended for the user, ex: program started" );
Logger::debug( "a diagnostic message intended for the developer, ex: variable value = false" );
Logger::warning( "a warning that something might go wrong, ex: variable not set, something bad might happen" );
Logger::error( "explain why the program is going to crash, ex: file not found, exiting" );
```

will print to STDOUT the following lines:

```
$> 2018-04-09T16:21:34+02:00 [INFO] : an informational message intended for the user, ex: program started
$> 2018-04-09T16:21:34+02:00 [DEBUG] : a diagnostic message intended for the developer, ex: variable value = false
$> 2018-04-09T16:21:34+02:00 [WARNING] : a warning that something might go wrong, ex: variable not set, something bad might happen
$> 2018-04-09T16:21:34+02:00 [ERROR] : explain why the program is going to crash, ex: file not found, exiting
```

To write the same output to file, prepend the following line:

```php
Logger::$write_log = true;
```

To customize the log file path:

```php
Logger::$log_dir = 'logs';
Logger::$log_file_name = 'log';
Logger::$log_file_extension = 'log';
```

To overwrite the log file at every run of the script:

```php
Logger::$log_file_append = false;
```

To prevent printing to screen:

```php
Logger::$print_log = false;
```

## Parallel code caveat

The class uses the static methods and internal flags (e.g. `$logger_ready`) to keep its state. We do this to make the class work straight away, without any previous configuration or the need to instantiate it. This however can create race conditions if you are executing parallel code. Please let us know if this is a problem for you, if we receive enough feedback, we will switch to a more class-like approach.
