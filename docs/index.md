
### что нужно для подгрузки стилей из других модулей

- Предзагруза View из Project - `Project::$aPreloadViews`
- Предзагруза View из модулей - `Module::$aPreloadViews`
- Предзагруза View из контроллеров - `Controller::$aPreloadViews`

### Классы списков

- [роутинг](src/Modules/Core/Aliases.php)
- [команды](src/Modules/Core/Commands.php)
- [генераторы](src/Modules/Core/Generators.php)
- [модуль](src/Modules/Core/Module.php)
- [вьюхи](src/Modules/Core/View.php)
