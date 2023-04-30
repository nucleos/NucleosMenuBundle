# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.5.0 - TBD

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

## 2.4.0 - 2023-04-30


-----

### Release Notes for [2.4.0](https://github.com/nucleos/NucleosMenuBundle/milestone/7)

Feature release (minor)

### 2.4.0

- Total issues resolved: **0**
- Total pull requests resolved: **3**
- Total contributors: **1**

#### dependency

 - [499: Drop symfony 6.1 support](https://github.com/nucleos/NucleosMenuBundle/pull/499) thanks to @core23
 - [497: Drop support for PHP 8.0](https://github.com/nucleos/NucleosMenuBundle/pull/497) thanks to @core23

#### Enhancement

 - [498: Update build tools](https://github.com/nucleos/NucleosMenuBundle/pull/498) thanks to @core23

## 2.3.0 - 2021-12-06


-----

### Release Notes for [2.3.0](https://github.com/nucleos/NucleosMenuBundle/milestone/3)

Feature release (minor)

### 2.3.0

- Total issues resolved: **0**
- Total pull requests resolved: **6**
- Total contributors: **1**

#### dependency

 - [379: Add support for symfony/translation-contracts 3](https://github.com/nucleos/NucleosMenuBundle/pull/379) thanks to @core23
 - [378: Add symfony 6 support](https://github.com/nucleos/NucleosMenuBundle/pull/378) thanks to @core23
 - [377: Drop symfony 4 support](https://github.com/nucleos/NucleosMenuBundle/pull/377) thanks to @core23
 - [369: Drop PHP 7 support](https://github.com/nucleos/NucleosMenuBundle/pull/369) thanks to @core23

#### Enhancement

 - [376: Update tools and use make to run them](https://github.com/nucleos/NucleosMenuBundle/pull/376) thanks to @core23
 - [241: Fix test config](https://github.com/nucleos/NucleosMenuBundle/pull/241) thanks to @core23

## 2.2.1 - 2021-02-25


-----

### Release Notes for [2.2.1](https://github.com/nucleos/NucleosMenuBundle/milestone/2)

2.2.x bugfix release (patch)

### 2.2.1

- Total issues resolved: **0**
- Total pull requests resolved: **2**
- Total contributors: **1**

#### Bug

 - [230: Fix service parameter](https://github.com/nucleos/NucleosMenuBundle/pull/230) thanks to @core23
 - [229: Add missing provider tag to ConfigProvider](https://github.com/nucleos/NucleosMenuBundle/pull/229) thanks to @core23

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
