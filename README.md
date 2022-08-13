# wapp_test_snotes

Фреймфорк для создания простых проектов на php.

### Что нужно прописывать в массивах

- При создании модуля
    - в src/Modules/[МОДУЛЬ]/Module.php
        - Добавить $sDefaultController
        - Добавить $sDefaultMethod
        - Добавить $aControllers
        - Добавить $aPreloadViews
    - в src/Modules/[МОДУЛЬ]/Aliases.php
        - Добавить альясы
    - в src/Modules/[МОДУЛЬ]/Commands.php
        - Добавить $aCommands
    - в src/Modules/[МОДУЛЬ]/View.php
        - Добавить TEMPLATES_PATH
        - Добавить $sDefaultLayoutTemplate
        - Добавить $sDefaultContentTemplate
    - в src/Modules.php
        - $aModules - добавить класс модуля
        - $aAliases - добавить яльясы модуля
        - $aCommands - добавить комманды модуля
