# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).
The [Keep a Changelog](http://keepachangelog.com/) format will be
used to track changes in this project.

## [Unreleased]

### Added
- [#53](../../issues/53): Admin user should be able to manage attachments (multiple features)
- CreateCatalogPromotionCommand

### Changed
- [#42](../../issues/42): Change all use case Actions to require a string ID instead of UuidInterface
- [#21](../../issues/21): Cart price rules carried over and linked to an Order (DB migration)
- [#40](../../issues/40): Change ProductRepository::getRelatedProductsByIds to not require $tagIds
- [#47](../../issues/47): Modify OrderItem to require Order in the constructor
- Deprecated CatalogPromotion.code

### DB Migration
- TBD

## [0.6.0]

### Initial pre-release
