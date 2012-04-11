# Deploying WRC

## File Change on Server:
file: `wp-content/plugins/wordpress-importer/wordpress-importer.php`
make change: `define( 'IMPORT_DEBUG', true );`

## WP3 Network Admin setting change:
append to "Upload file types":
`doc docx docm xls xlsx xlsm xlt xltx xltm ppt pptx pptm`

## Creating the WP3 site
- add wrc through network admin
- title: UCF Office of the WRC and Vice President for Academic Affairs
- appearance > enable theme
- users > add : pburt
- import content from webcom
	+ map all to pburt
	+ should not encounter a single error
- settings > reading : static page > front page > home

### Appearance > Widgets, Primary Aside

Text Widget, "Events at UCF":
    
    <div data-calendar-id="1" data-url="http://events.ucf.edu" class="events" data-limit="3">
        <a href="http://events.ucf.edu/?calendar_id=1">View Calendar</a>
    </div>

Menu, "Academic Resources and Links"

Menu, "Human Resources Links"