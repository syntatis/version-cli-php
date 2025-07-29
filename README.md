# 1️⃣ version-cli-php

A simple PHP CLI tool for working with [SemVer](https://semver.org/) version strings.

## Features

* Increment version by major, minor, or patch
* Compare two version strings
* Validates SemVer-compliant version strings

## Requirements

* PHP 7.0 or higher
* Composer

## 📦 Installation

You can install it globally or locally using Composer:

```bash
composer global require syntatis/version-cli-php

Or to use as a development dependency in your project:

composer require --dev syntatis/version-cli-php

🚀 Usage

Run the CLI using:

version

If installed locally:

vendor/bin/version

🔼 Increment a version

version bump 1.2.3 patch
# Output: 1.2.4

version bump 1.2.3 minor
# Output: 1.3.0

version bump 1.2.3 major
# Output: 2.0.0

⚖️ Compare versions

version compare 1.2.3 1.2.4
# Output: -1 (meaning 1.2.3 < 1.2.4)

version compare 2.0.0 1.9.9
# Output: 1 (meaning 2.0.0 > 1.9.9)

version compare 1.2.3 1.2.3
# Output: 0 (meaning both are equal)

🧪 Testing

Run tests using PHPUnit:

composer test

📄 License

MIT © Syntatis

Let me know if this tool supports pre-releases (`1.0.0-beta.1`) or build metadata (`+001`), so I can include that in the README too.
