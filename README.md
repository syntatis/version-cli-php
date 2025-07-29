# 1️⃣ version-cli-php

[![CI](https://github.com/syntatis/version-cli-php/actions/workflows/ci.yml/badge.svg)](https://github.com/syntatis/version-cli-php/actions/workflows/ci.yml)

A simple PHP CLI tool for working with [SemVer](https://semver.org/) version strings.

## Features

* Increment version by major, minor, or patch
* Compare two version strings
* Validates SemVer-compliant version strings

## Getting Started

### Requirements

* PHP 7.4 or higher
* Composer

### Installation

You can install it globally or locally using Composer:

```bash
composer global require syntatis/version-cli
```

Or, use as a development dependency in your project:

```bash
composer require --dev syntatis/version-cli
```

## Commands

If you run it globally, you can use the `version` command directly in your terminal:

```bash
version --help
```

If you installed it locally in your project, run it using the vendor binary:

```bash
vendor/bin/version --help
```

The command provides several options to work with version strings:

<table>
    <thead>
        <th>Command</th>
        <th>Description</th>
		<th>Usage</th>
    </thead>
    <tbody>
        <tr>
            <td><code>validate</code></td>
            <td>Validates the given version string against the SemVer specification.</td>
			<td><code>version validate v1.0.0</code></td>
        </tr>
	</tbody>
</table>

For more details on each command, run:

```bash
version list
```
