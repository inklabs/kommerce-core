# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).
The [Keep a Changelog](http://keepachangelog.com/) format will be
used to track changes in this project.

## [Unreleased]
### Added
- Cart
  - CopyCartItemsCommand
  - DeleteCartItemCommand
  - RemoveCartCommand
  - SetCartSessionIdCommand
  - SetCartUserCommand
  - GetCartQuery
  - GetCartBySessionIdQuery
  - GetCartByUserIdQuery
- Product
  - AddTagToProductCommand
  - CreateProductCommand
  - RemoveTagFromProductCommand
  - UpdateProductCommand
  - GetProductQuery
  - GetRelatedProductsQuery
  - GetRandomProductsQuery
- User
  - LoginCommand
  - GetUserQuery
  - GetUserByEmailQuery

### Changed
- Migrate to UUIDs for primary keys
- LoginWithTokenQuery to LoginWithTokenCommand
- Moved raising OrderShippedEvent from OrderService::addShipment() to Order::addShipment()
- Moved raising ResetPasswordEvent from UserService::requestPasswordResetToken() to UserToken::createResetPasswordToken()
