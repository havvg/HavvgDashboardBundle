# Twig

## Services

To make use of the `TwigRenderer` the `DashboardExtension` needs to be loaded:

```yaml
services:
    havvg_dashboard.renderer.twig:
        class: Havvg\Bundle\DashboardBundle\Dashboard\Renderer\TwigRenderer
        arguments:
            - '@twig'
        calls:
            -
                - 'configure'
                -
                    -
                        template: '::boardlets.html.twig'
                        default_block: 'boardlet_default'

    havvg_dashboard.twig.extension:
        class: Havvg\Bundle\DashboardBundle\Twig\DashboardExtension
        arguments:
            - '@havvg_dashboard.renderer.twig'
        tags:
            - { name: 'twig.extension' }
```

The `DashboardExtension` adds a `havvg_dashboard_render` function to Twig.
The first argument of this function is a `Boardlet` to render,
the second optional argument is a list of additional options being passed to the block being rendered.

## Template

An example `boardlets.html.twig` may look like this:

```html+jinja
{# The default fallback block for all boardlets not having a block defined. #}
{% block boardlet_default %}
<section class="boardlet">
    <header>{{ boardlet.name }}</header>
    <p>The boardlet is missing a template.</p>
</section>
{% endblock %}

{# Example block rendering an ActiveUsersBoardlet #}
{% block boardlet_active_users %}
<section class="boardlet">
    <header>{{ boardlet.name }}</header>
    <p>There are currently <span class="data-value">{{ boardlet.data.current }}</span> users online.</p>
    <p>Yesterdays record was <span class="data-value">{{ boardlet.data.yesterday_record }}</span>.</p>
</section>
{% endblock %}
```

## Rendering a dashboard

Rendering a dashboard is as simple as those two files:

```php
<?php
// src/Acme/Bundle/DemoBundle/Controller/DashboardController.php

namespace Acme\Bundle\DemoBundle\Controller;

class DashboardController extends AbstractController
{
    public function indexAction()
    {
        // retrieve or create a dashboard
        $dashboard = $this->get('dashboard.default');

        return $this->render('AcmeDemoBundle:Dashboard:index.html.twig', array(
            'dashboard' => $dashboard,
        ));
    }
}
```

```jinja
{# src/Acme/Bundle/DemoBundle/Resources/views/Dashboard/index.html.twig #}

{# render each boardlet in the dashboard #}
{% for boardlet in dashboard %}
    {{ havvg_dashboard_render(boardlet) }}
{% endfor %}
```
