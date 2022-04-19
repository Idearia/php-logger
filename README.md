# PHP Logger

Simple logger class to:

* Keep track of log entries.
* Keep track of timings with `time()` and `timeEnd()` methods, Javascript style.
* Optionally write log entries in real-time to file or to screen.
* Optionally dump the log to file in one go at any time.

Log entries can be added with any of the following methods:

* `debug( $message, $title = '' )` > a diagnostic message intended for the developer
* `info( $message, $title = '' )`  > an informational message intended for the user
* `warning( $message, $title = '' )` > a warning that something might go wrong
* `error( $message, $title = '' )` > explain why the program is going to crash

The `$title` argument is optional; if present, it will be prepended to the message: "$title => $message".

# Quick example

The following code:

```php
Logger::$log_level = 'debug';
Logger::debug( "variable x is false" );
Logger::info( "program started" );
Logger::warning( "variable not set, something bad might happen" );
Logger::error( "file not found, exiting" );
```

will print to STDOUT the following lines:

```
$> 2021-07-21T11:11:03+02:00 [DEBUG] : variable x is false
$> 2021-07-21T11:11:03+02:00 [INFO] : program started
$> 2021-07-21T11:11:03+02:00 [WARNING] : variable not set, something bad might happen
$> 2021-07-21T11:11:03+02:00 [ERROR] : file not found, exiting
```

# Timing

You can keep track of elapsed time by using the `time()` and `timeEnd()` function.

### Timing example

```php
Logger::time();
sleep(1);
Logger::timeEnd();
```

will print:

```
$> 2022-04-19T17:26:26+00:00 [DEBUG] : Elapsed time => 1.003163 seconds
```

### Named timers

If you need to time different processes at the same time, you can use named timers.

For example:

```php
Logger::time('outer timer');
sleep(1);
Logger::time('inner timer');
sleep(1);
Logger::timeEnd('inner timer');
Logger::timeEnd('outer timer');
```

will print:

```
$> 2022-04-19T17:32:15+00:00 [DEBUG] : Elapsed time for 'inner timer' => 1.002268 seconds
$> 2022-04-19T17:32:15+00:00 [DEBUG] : Elapsed time for 'outer timer' => 2.006117 seconds
```


# Options

To customize the logger, you can either:

- extend the class and override the static properties or
- set the static properties at runtime.

In the following examples, we adopt the second approach.

## Set the log level

By default, the logger will assume it runs in production and, therefore, will print only error-level messages.

Specify your desired log level in the following way:

```php
Logger::$log_level = 'error'; // Show only errors
Logger::$log_level = 'warning'; // Show warnings and errors
Logger::$log_level = 'info'; // Show info messages, warnings and errors
Logger::$log_level = 'debug'; // Show debug messages, info messages, warnings and errors
```

## Write to file

To also write to file, set:

```php
Logger::$write_log = true;
```

To customize the log file path:

```php
Logger::$log_dir = 'logs';
Logger::$log_file_name = 'my-log';
Logger::$log_file_extension = 'log';
```

To overwrite the log file at every run of the script:

```php
Logger::$log_file_append = false;
```

## Do not print to screen

To prevent printing to STDOUT:

```php
Logger::$print_log = false;
```

# Parallel code caveat

The class uses the static methods and internal flags (e.g. `$logger_ready`) to keep its state. We do this to make the class work straight away, without any previous configuration or the need to instantiate it. This however can create race conditions if you are executing parallel code. Please let us know if this is a problem for you, if we receive enough feedback, we will switch to a more class-like approach.

# Contributing 🙂

Feel free to fork the repository and make a pull request!

Before sending the request, please make sure your code passes all the tests:

```
composer run test
```
