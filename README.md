# QuickStats Plugin for Moodle

The QuickStats plugin (local_quickstats) provides administrators with a simple dashboard to track the number of active users over a specified period (e.g., the last N days). It also includes a chart for visualizing trends in active users over time.

## Installation

1. Download the QuickStats plugin from your repository or package source.
2. Place the plugin in the following location within your Moodle directory:
[yourmoodledir]/local/quickstats
3. Navigate to **Site Administration > Notifications** in Moodle to complete the installation process.

## Configuring the QuickStats Plugin

To configure the plugin:

1. Go to the QuickStats settings page:
Site Administration > Plugins > Local plugins > QuickStats
2. Configure the following settings:
**Enable QuickStats**: Turn the plugin on or off.
**Number of Active Days**: Define the number of days to consider a user as active.
3. Save the settings.

Once configured, the plugin will begin tracking active users.

## Features

### Dashboard

The plugin provides a dashboard that shows:
The current number of active users.
A line chart displaying trends in active users over the last few records.

### Manual Refresh

You can manually refresh the statistics by clicking the **Refresh Statistics** button on the dashboard page.

### Automatic Updates

The plugin includes a scheduled task to automatically update the active user statistics daily.

### Data Table

The plugin stores active user statistics in a custom database table:
**local_quickstats**:
 - id: Primary key.
 - activeuserscount: Number of active users.
 - periodstart: Start time of the data collection period.
 - periodend: End time of the data collection period.
 - timecreated: Timestamp when the record was created.

## Uninstall

1. Remove the plugin files from the Moodle directory:
[yourmoodledir]/local/quickstats
2. Go to **Site Administration > Plugins > Plugins overview**.
3. Find the plugin (QuickStats) and click **Uninstall**.
4. Follow the prompts to remove the database tables and complete the uninstallation.
