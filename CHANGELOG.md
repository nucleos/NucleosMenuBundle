# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.2.1 - TBD

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.2.0 - 2021-02-09



-----

### Release Notes for [2.2.0](https://github.com/nucleos/NucleosMenuBundle/milestone/1)



### 2.2.0

- Total issues resolved: **0**
- Total pull requests resolved: **3**
- Total contributors: **1**

#### dependency

 - [139: Add support for PHP 8](https://github.com/nucleos/NucleosMenuBundle/pull/139) thanks to @core23

#### Bug

 - [59: Move configuration to PHP](https://github.com/nucleos/NucleosMenuBundle/pull/59) thanks to @core23

#### Feature Request

 - [58: Move configuration to PHP](https://github.com/nucleos/NucleosMenuBundle/pull/58) thanks to @core23

## 2.1.0

### 📦 Dependencies

- Add support for sonata/block-bundle 3

## 2.0.0

### Changed

* Renamed namespace `Core23\MenuBundle` to `Nucleos\MenuBundle` after move to [@nucleos]

  Run

  ```
  $ composer remove core23/menu-bundle
  ```

  and

  ```
  $ composer require nucleos/menu-bundle
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Core23\\MenuBundle/Nucleos\\MenuBundle/g' {} \;
  ```

  to replace occurrences of `Core23\MenuBundle` with `Nucleos\MenuBundle`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.


## 1.1.0

### Changes

- Add missing strict file header [@core23] ([#33])
- Removed explicit private visibility of services [@core23] ([#13])

### 📦 Dependencies

- Add support for KnpMenu 3 [@core23] ([#46])
- Add support for symfony 5 [@core23] ([#23])
- Use latest block bundle for auto-registration of blocks [@core23] ([#20])
- Bump sonata BlockBundle dependency [@core23] ([#34])
- Drop support for symfony 3 [@core23] ([#30])

[#46]: https://github.com/nucleos/NucleosMenuBundle/pull/46
[#34]: https://github.com/nucleos/NucleosMenuBundle/pull/34
[#33]: https://github.com/nucleos/NucleosMenuBundle/pull/33
[#30]: https://github.com/nucleos/NucleosMenuBundle/pull/30
[#23]: https://github.com/nucleos/NucleosMenuBundle/pull/23
[#20]: https://github.com/nucleos/NucleosMenuBundle/pull/20
[#13]: https://github.com/nucleos/NucleosMenuBundle/pull/13
[@nucleos]: https://github.com/nucleos
[@core23]: https://github.com/core23
