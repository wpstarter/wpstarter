# Project context

`wpstarter/wpstarter` is a WordPress plugin/application skeleton using the Laravel-style `wpstarter/framework`. See `README.md` for setup and layout.

- Runtime framework: `vendor/wpstarter/framework/`; classes: `src/WpStarter/`, WordPress integration: `src/WpStarter/Wordpress/` within that package. Read its `AGENTS.md` when investigating framework behavior.
- Separate local framework checkout: `D:/wpstarter/framework`; changes there do not automatically affect this app.
- Entry/lifecycle: `main.php`, `WordpressStarter.php`, `bootstrap/`. Put application changes in `app/`, `routes/`, `resources/`, and `config/`; edit framework only for framework tasks.
- Use `WpStarter\` imports and existing `ws_*` helpers; verify APIs in installed source. Preserve WordPress hook timing, users, and database integration.
- Route facades: HTTP `WpStarter\Support\Facades\Route`; shortcode `WpStarter\Wordpress\Facades\Route`; admin `WpStarter\Wordpress\Admin\Facades\Route`.
- Lint changed PHP; run relevant checks when available. PHPUnit requires the testbench bootstrap referenced by `phpunit.xml`. Report unrun checks; finish with `git diff --check`.
