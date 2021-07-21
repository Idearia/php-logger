# PHP Logger

Simple logger class to:

* Keep track of log entries.
* Keep track of timings with `time()` and `timeEnd()` methods, Javascript style.
* Optionally write log entries in real-time to file or to screen.
* Optionally dump the log to file in one go at any time.

Log entries can be added with any of the following methods:

* `info( $message, $title = '' )`  > an informational message intended for the user
* `debug( $message, $title = '' )` > a diagnostic message intended for the developer
* `warning( $message, $title = '' )` > a warning that something might go wrong
* `error( $message, $title = '' )` > explain why the program is going to crash

The `$title` argument is optional; if present, it will be prepended to the message: "$title => $message".

For example, the following code

```php
Logger::info( "program started" );
Logger::debug( "variable x is false" );
Logger::warning( "variable not set, something bad might happen" );
Logger::error( "file not found, exiting" );
```

will print to STDOUT the following lines:

```
$> 2021-07-21T11:11:03+02:00 [INFO] : program started
$> 2021-07-21T11:11:03+02:00 [DEBUG] : variable x is false
$> 2021-07-21T11:11:03+02:00 [WARNING] : variable not set, something bad might happen
$> 2021-07-21T11:11:03+02:00 [ERROR] : file not found, exiting
```

To also write to file, prepend the following line:

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
