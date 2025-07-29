# 1️⃣ version-cli-php

A simple PHP CLI tool for working with [SemVer](https://semver.org/) version strings.

## Features

* Increment version by major, minor, or patch
* Compare two version strings
* Validates SemVer-compliant version strings

## Requirements

* PHP 7.4 or higher
* Composer

## Installation

You can install it globally or locally using Composer:

```bash
composer global require syntatis/version-cli
```

Or, use as a development dependency in your project:

```bash
composer require --dev syntatis/version-cli
```

## Usage

If you run it globally, you can use the `version` command directly in your terminal:

```bash
version --help
```

If you installed it locally in your project, run it using the vendor binary:

```bash
vendor/bin/version --help
```
## Commands
