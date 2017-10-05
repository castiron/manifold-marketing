# Google Analytics Configuration

Configure this feature to enable analytics reporting to your Google account, and to display analytics data in the Manifold backend.

### Requirements

Before adding Google Analytics support to Manifold, you will need a Google developer account and a Manifold Google project.

* If you do not have a developer account you can create one at through the [Google Developer Console](https://console.developers.google.com/).
* If you do not have a Manifold Google project you can create one by logging into your developer account and clicking "Create Project".

### Get project ID

1. Log into your project at [Google Cloud Platform](https://console.cloud.google.com).
2. Make note of the Project ID after the "#" in the "Project Info" card.

![Analytics Project](/assets/analytics-project.png)

### Enable analytics

1. Click on the "API Manager" tab in the sidebar.
2. Click on the "Library" tab in the sidebar.
3. Click on "Analytics API" under the "Other popular APIs" header. (You may need to search for "Analytics API" if you don't see it.
4. Click "Enable".

### Get service account credentials

1. Click on the "Credentials" tab in the sidebar.
2. Click to create credentials set for a "Service account key".
3. Select "New service account" from the dropdown.
4. Give your service account a name.
6. Create the credential set.
7. Download and locate the JSON file.
8. Put the JSON file into your app's root directory.
9. Click on "Manage service accounts".
10. Make note of the Service account ID and Key ID.

![Analytics New Service](/assets/analytics-new.png)

![Analytics Service](/assets/analytics-service.png)

### Configure analytics

1. Log into your property at [Google Analytics](https://analytics.google.com).
2. Create a new property for your Manifold installation. If you need help, instructions can be found at [Analytics Help](https://support.google.com/analytics/answer/1008015?hl=en).
3. Click on the "Admin" tab in the sidebar.
4. Click on "User Management" under your property's name.
5. Add "Read & Anaylze" permissions for your service account.

![Analytics Permissions](/assets/analytics-permissions.png)

### Get Tracking ID and profile ID

1. Click on "Property Settings" under your property's name.
2. Make note of the Tracking Id including the "UA-" prefix.
3. Click on "View Settings" under "All Web Site Data".
4. Make note of the View Id.

![Analytics Tracking](/assets/analytics-tracking.png)

![Analytics Profile](/assets/analytics-profile.png)

### Update Manifold Settings

In the Manifold backend, navigate to the "settings" menu item. Under the "integration" tab, enter the values above into the corresponding fields.

If you manage settings in the environment \(`MANAGE_SETTINGS_FROM_ENV=1` in your `.env` file\), you should set the corresponding settings in `.env`:

```
# Google Drive Integration
MANIFOLD_SETTING_INTEGRATIONS_GOOGLE_CLIENT_ID=
MANIFOLD_SETTING_INTEGRATIONS_GOOGLE_PROJECT_ID=
MANIFOLD_SETTING_INTEGRATIONS_GOOGLE_PRIVATE_KEY_ID=
MANIFOLD_SETTING_SECRETS_GOOGLE_PRIVATE_KEY=
MANIFOLD_SETTING_INTEGRATIONS_GOOGLE_CLIENT_EMAIL=

# Google Analytics Integration
MANIFOLD_SETTING_INTEGRATIONS_GA_TRACKING_ID=
MANIFOLD_SETTING_INTEGRATIONS_GA_PROFILE_ID=
```