# Open Source Project Template

[![Release](https://img.shields.io/github/v/release/wayfair-incubator/oss-template?display_name=tag)](CHANGELOG.md)
[![Lint](https://github.com/wayfair-incubator/oss-template/actions/workflows/lint.yml/badge.svg?branch=main)](https://github.com/wayfair-incubator/oss-template/actions/workflows/lint.yml)
[![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-2.0-4baaaa.svg)](CODE_OF_CONDUCT.md)
[![Maintainer](https://img.shields.io/badge/Maintainer-Wayfair-7F187F)](https://wayfair.github.io)

## About The Project

The mainline purpose of this project is to build the PHP extension pdo_sqlrelay for
various PHP versions and various operating systems, and to perform continuous integration
and testing, utilizing the available containers already built and maintained by
other teams, and the [SQLRelay maintainers'](https://www.firstworks.com) prebuild binaries.

We do not intend on maintaining a fork of the pdo_sqlrelay.cpp source file, but only to mirror
a suitable release or patch from the upstream maintainer, and to support an
orchestration, using github actions, that ensure the usability of this extension in the
latest versions of PHP and operating system releases, database releases, etc as prudent
software lifecycle management practices indicate.

This project may not ever have releases or provide anything other than artifacts
of testing.

### File Catalog

| Directory | Filename   | Provenance | Description                             |
|-----------|------------|------------|-----------------------------------------|
| /         | config.m4  | Wayfair    | The input to the phpize command         |
| /         | \*         | Wayfair    | README etc                              |
| /src      | \*         | Firstworks | from SQLRelay src/api/phppdo            |
| /tests    | \*         | Wayfair    | phpt files containing sql               |
| /.github  | \*         | Wayfair    | Workflows and templates                 |
| /bin      | \*         | Wayfair    | Scripts to help build and test          |

## Getting Started

In a suitable PHP development environment, with prequisite software installed,
the pdo_sqlrelay.so can be built by:

```sh
phpize --clean; phpize; ./configure; make clean; make;
```

The make test will fail until the generated Makefile is edited to include the
loading of the extension=pdo.so or until we figure out what to change in
the config.m4 to get this to happen automatically. The github actions
will have calls to sed to do this editing.

### Prerequisites

These all refer to prebuild binaries, e.g. RPM, APT, from customary sources.

1. php-devel possibly from [blog.remirepo.net](https://blog.remirepo.net/) or provided by your OS distro.
2. rudiments-devel from [firstworks.com/opensource](https://www.firstworks.com/opensource.html)
3. sqlrelay-c++-devel as above.
4. php-debuginfo (strongly suggested)
5. sqlrelay-debuginfo (strongly suggested)
6. gcc-c++, valgrind, gdb, strace, ltrace, binutils (obviously).

### Installation

```sh
phpize --clean; phpize; ./configure; make clean; make;
```

## Usage

See [firstworks.com/opensource](https://www.firstworks.com/opensource.html)

## Roadmap

See the [open issues](https://github.com/org_name/repo_name/issues) for a list of proposed features (and known issues).

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**. For detailed contributing guidelines, please see [CONTRIBUTING.md](CONTRIBUTING.md)

## License

Wayfair provided files distributed under the `MIT` License.
See `LICENSE` for more information. other files as indicated by the upstream sources.

## Contact

Project Link: [https://github.com/wayfair-incubator/pdo_sqlrelay_builder](https://github.com/wayfair-incubator/pdo_sqlrelay_builder)

## Acknowledgements

This template was adapted from
[https://github.com/othneildrew/Best-README-Template](https://github.com/othneildrew/Best-README-Template).
