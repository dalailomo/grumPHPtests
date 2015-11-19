# GrumPHP Features

This guide is to show the main features of GrumPHP in a quick way. For a full detailed documentation you can check the official GrumPHP repository: [https://github.com/phpro/grumphp]()

Let's play with GrumPHP!

## Installation

To add GrumPHP to this project we have this basic composer file.

```
{
    "autoload": {
        "psr-4": {
            "Kapusta\\": "Lib/",
            "Kapusta\\Tests\\": "Test/"
        }
    },
    "require": {
        "phpro/grumphp": "^0.5.2",
        "behat/behat": "^3.0",
        "fabpot/php-cs-fixer": "^1.10",
        "phpspec/phpspec": "^2.3",
        "phpunit/phpunit": "4.8",
        "squizlabs/php_codesniffer": "^2.3",
        "php": "5.5.*"
    }
}
```

Do a `composer update` and GrumPHP will automatically add itself to your githooks.


## GrumPHP configuration file

Here is the main place where everything comes into the play. This is how it looks:

```
parameters:
    git_dir: "."
    bin_dir: "./vendor/bin"
    ascii:
        failed: grumphp-grumpy.txt
        succeeded: grumphp-happy.txt
    tasks:
        blacklist:
            keywords:
                - "*die("
                - "*var_dump("
                - "*exit;"
        git_commit_message:
            matchers:
                - "FOO-*"
        phpcsfixer: ~
        phpcs:
            standard: "PSR2"
            show_warnings: true
            tab_width: 4
        phpunit:
            config_file: "./Test/Unit/phpunit.xml"
```

So now we will go across all the options.

### Parameters `git_dir`, `bin_dir`, and `ascii`
```
    git_dir: "."
    bin_dir: "./vendor/bin"
```
These are pretty straighfoward, just to tell where the `.git/` and `vendor/` folders are located relatively to the configuration file.

```
    ascii:
        failed: grumphp-grumpy.txt
        succeeded: grumphp-happy.txt
```
These are used to show our funky Yoda ascii portrait.

### Parameter `tasks`

Here is where the magic happens:

#### Task `blacklist`

```
		blacklist:
            keywords:
                - "*die("
                - "*var_dump("
                - "*exit;"
```

The `blacklist` task is used to check if any of those patterns are used in the files containing changes. If the task find any of the defined patterns, the commit will not be made until those are removed.

You would see something like this:

```
$ git commit -m "FOO-x: Trying to commit stuff"
GrumPHP detected a pre-commit command.
GrumPHP is sniffing your code!
Running task 1/4: Phpcs
Running task 2/4: Phpcsfixer
Running task 3/4: Phpunit
Running task 4/4: Blacklist
                   ____
                _.' :  `._
            .-.'`.  ;   .'`.-.
   __      / : ___\ ;  /___ ; \      __
 ,'_ ""--.:__;".-.";: :".-.":__;.--"" _`,
 :' `.t""--.. '<@.`;_  ',@>` ..--""j.' `;
      `:-.._J '-.-'L__ `-- ' L_..-;'
        "-.__ ;  .-"  "-.  : __.-"
            L ' /.------.\ ' J
             "-.   "--"   .-"
            __.l"-:_JL_;-";.__

            Going bananas, your repository is.  Yes, hmmm.

You have blacklisted keywords in your commit:
index.php:8:var_dump($jandemor);
index.php:11:die('hey');
```

#### Task `git_commit_message`

```
		git_commit_message:
            matchers:
                - "FOO-*"
```

The `git_commit_message` parameter in this case, forces you to prefix your commit message with `FOO-`.

If you try to commit something without the defined prefix, you would see something like this:

```
$ git commit -m "Trying to commit stuff"
GrumPHP detected a pre-commit command.
GrumPHP is sniffing your code!
Running task 1/4: Phpcs
Running task 2/4: Phpcsfixer
Running task 3/4: Phpunit
Running task 4/4: Blacklist
GrumPHP detected a commit-msg command.
GrumPHP is sniffing your code!
Running task 1/1: CommitMessage
                   ____
                _.' :  `._
            .-.'`.  ;   .'`.-.
   __      / : ___\ ;  /___ ; \      __
 ,'_ ""--.:__;".-.";: :".-.":__;.--"" _`,
 :' `.t""--.. '<@.`;_  ',@>` ..--""j.' `;
      `:-.._J '-.-'L__ `-- ' L_..-;'
        "-.__ ;  .-"  "-.  : __.-"
            L ' /.------.\ ' J
             "-.   "--"   .-"
            __.l"-:_JL_;-";.__

            Going bananas, your repository is.  Yes, hmmm.

The commit message does not match the rule: FOO-*
```

### Tasks `phpcsfixer` and `phpcs`

```
        phpcsfixer: ~
        phpcs:
            standard: "PSR2"
            show_warnings: true
            tab_width: 4
```

These tasks works together somehow. If we try to commit something whcih violates the **PSR2** standards, we will see some issues when we try to commit those changes.

Lets try to modify some code in the existing class `Jandemor`.

Suppose we have the class file like this:

```
<?php

namespace Kapusta;

class Jandemor
{
    /**
     * @var string
     */
    protected $krander = 'Hello Default!';

    /**
     * Krander method to do krander things.
     *
     * @param null|string $krander
     *
     * @return null|string
     */
    public function krander($krander = null)
    {
        if (isset($krander)) {
            $this->krander = $krander;
        }

        return $this->krander;
    }
}


```

Lets do some mess here... something like the following

```
<?php
namespace Kapusta;


class Jandemor
{
    
    /**
     * @var string
     */
    protected $krander='Hello Default!';

    /**
     * Krander method to do krander things.
     *
     * @param null|string $krander
     *
     * @return null|string
     */
    public function krander($krander = null) {
        if (isset($krander)) 
        {
            $this->krander = $krander;
        }

        return $this->krander;
    }

}
```

If you try to commit this little monster, you would see something like the following:

```
$ git commit -m "FOO-x: Trying to commit stuff"
GrumPHP detected a pre-commit command.
GrumPHP is sniffing your code!
Running task 1/4: Phpcs
Running task 2/4: Phpcsfixer
Running task 3/4: Phpunit
Running task 4/4: Blacklist
                   ____
                _.' :  `._
            .-.'`.  ;   .'`.-.
   __      / : ___\ ;  /___ ; \      __
 ,'_ ""--.:__;".-.";: :".-.":__;.--"" _`,
 :' `.t""--.. '<@.`;_  ',@>` ..--""j.' `;
      `:-.._J '-.-'L__ `-- ' L_..-;'
        "-.__ ;  .-"  "-.  : __.-"
            L ' /.------.\ ' J
             "-.   "--"   .-"
            __.l"-:_JL_;-";.__

            Going bananas, your repository is.  Yes, hmmm.


FILE: /Users/psanchez/Sites/grumPHPtests/Lib/Jandemor.php
----------------------------------------------------------------------
FOUND 5 ERRORS AFFECTING 4 LINES
----------------------------------------------------------------------
  2 | ERROR | [x] There must be one blank line after the namespace
    |       |     declaration
 20 | ERROR | [x] Opening brace should be on a new line
 21 | ERROR | [x] Expected 1 space after closing parenthesis; found 9
 29 | ERROR | [x] Expected 1 newline at end of file; 0 found
 29 | ERROR | [x] The closing brace for the class must go on the next
    |       |     line after the body
----------------------------------------------------------------------
PHPCBF CAN FIX THE 5 MARKED SNIFF VIOLATIONS AUTOMATICALLY
----------------------------------------------------------------------

Time: 58ms; Memory: 3.5Mb


1) /Users/psanchez/Sites/grumPHPtests/Lib/Jandemor.php (blankline_after_open_tag,operators_spaces,no_blank_lines_after_class_opening,extra_empty_lines,braces,eof_ending)

You can fix all errors by running following commands:
'./vendor/bin/php-cs-fixer' '--config=default' '--verbose' 'fix' 'Lib/Jandemor.php'
```

Note the last part of the message, that we can use the phpcsfixer to actually fix all the marked issues. There are some cases when the issues cannot be fixed automatically.

Then if you run the task, you would see something like the following:

```
$ ./vendor/bin/php-cs-fixer --config=default --verbose fix Lib/Jandemor.php
F
Legend: ?-unknown, I-invalid file syntax, file ignored, .-no changes, F-fixed, E-error
   1) /Users/psanchez/Sites/grumPHPtests/Lib/Jandemor.php (blankline_after_open_tag, operators_spaces, no_blank_lines_after_class_opening, extra_empty_lines, braces, eof_ending)
Fixed all files in 0.233 seconds, 5.500 MB memory used
```

> Note: I don't know yet the reason why we get this warning, but actually, the file is fixed.

Then if you check the code, now will look like this: 

```
<?php

namespace Kapusta;

class Jandemor
{
    /**
     * @var string
     */
    protected $krander = 'Hello Default!';

    /**
     * Krander method to do krander things.
     *
     * @param null|string $krander
     *
     * @return null|string
     */
    public function krander($krander = null)
    {
        if (isset($krander)) {
            $this->krander = $krander;
        }

        return $this->krander;
    }
}


```

### Task `phpunit`

```
        phpunit:
            config_file: "./Test/Unit/phpunit.xml"
```

This task will run the unit tests when we try to commit. If there is any unit test failing when trying to commit something, you would see something like this:

```
$ git commit -m "FOO-x: Trying to commit stuff"
GrumPHP detected a pre-commit command.
GrumPHP is sniffing your code!
Running task 1/4: Phpcs
Running task 2/4: Phpcsfixer
Running task 3/4: Phpunit
Running task 4/4: Blacklist
                   ____
                _.' :  `._
            .-.'`.  ;   .'`.-.
   __      / : ___\ ;  /___ ; \      __
 ,'_ ""--.:__;".-.";: :".-.":__;.--"" _`,
 :' `.t""--.. '<@.`;_  ',@>` ..--""j.' `;
      `:-.._J '-.-'L__ `-- ' L_..-;'
        "-.__ ;  .-"  "-.  : __.-"
            L ' /.------.\ ' J
             "-.   "--"   .-"
            __.l"-:_JL_;-";.__

            Going bananas, your repository is.  Yes, hmmm.

PHPUnit 4.8.0 by Sebastian Bergmann and contributors.

..F

Time: 107 ms, Memory: 4.25Mb

There was 1 failure:

1) Kapusta\Tests\JandemorTest::testKrander with data set #2 (null, 'Hello Default!')
Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-Hello Default!
+Hello another different Default!

/Users/psanchez/Sites/grumPHPtests/Test/Unit/JandemorTest.php:38

FAILURES!
Tests: 3, Assertions: 3, Failures: 1.

```

### Task `behat`
@TODO

## When everything is OK and beautiful

When you try to commit and everything is ok, you should see something like the following:

```
$ git commit -m "FOO-x: Added README"
GrumPHP detected a pre-commit command.
GrumPHP is sniffing your code!
Running task 1/4: Phpcs
Running task 2/4: Phpcsfixer
Running task 3/4: Phpunit
Running task 4/4: Blacklist
GrumPHP detected a commit-msg command.
GrumPHP is sniffing your code!
Running task 1/1: CommitMessage
                   ____
                _.' :  `._
            .-.'`.  ;   .'`.-.
   __      / : ___\ ;  /___ ; \      __
 ,'_ ""--.:__;".-.";: :".-.":__;.--"" _`,
 :' `.t""--.. '<@.`;_  ',@>` ..--""j.' `;
      `:-.._J '-.-'L__ `-- ' L_..-;'
        "-.__ ;  .-"  "-.  : __.-"
            L ' /.------.\ ' J
             "-.   "--"   .-"
            __.l"-:_JL_;-";.__

            Proud of you, Rick Astley would be.  Hmmmmmm.
[master a116690] FOO-x: Added README
 1 file changed, 397 insertions(+)
 create mode 100644 README.md
```