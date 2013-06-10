# DependencyInjection

## DashboardPass

The `DashboardPass` allows to simplify the service definitions for different dashboards.

It depends on the [HavvgDRYBundle](https://github.com/havvg/HavvgDRYBundle)
and makes use of the [AbstractTaggedMapCompilerPass](https://github.com/havvg/HavvgDRYBundle/blob/master/DependencyInjection/Compiler/AbstractTaggedMapCompilerPass.php)

```yaml
services:
    dashboard.default:
        class: Havvg\Bundle\DashboardBundle\Dashboard\Dashboard
        tags:
            - { name: 'havvg_dashboard.dashboard', alias: 'default' } # The alias reflects the name of the dashboard.

    boardlet.lead_distribution:
        class: Ormigo\Bundle\ReportingBundle\Dashboard\Boardlet\LeadDistributionBoardlet
        tags:
            - { name: 'havvg_dashboard.boardlet', target: 'default' } # This target is the same as the alias above.

    # A different dashboard with different boardlets.
    dashboard.business_intel:
        class: Havvg\Bundle\DashboardBundle\Dashboard\Dashboard
        tags:
            - { name: 'havvg_dashboard.dashboard', alias: 'business_intel' }

    boardlet.premium_accounts:
        class: Ormigo\Bundle\ReportingBundle\Dashboard\Boardlet\PremiumAccountsBoardlet
        tags:
            - { name: 'havvg_dashboard.boardlet', target: 'business_intel' }
```

[Back to the index](index.md)
