```markdown
# Testimonial Slider Pro

**Testimonial Slider Pro** is a WordPress plugin designed to help you create a testimonial slider with a smooth swiping experience, ideal for showcasing customer feedback and reviews. 

---

## Features

- **Customizable Slider**: Use Swiper.js to create beautiful testimonial sliders.
- **Responsive Design**: Perfectly adapts to any screen size.
- **Bootstrap Integration**: Admin panel styled with Bootstrap for a modern interface.
- **Database Integration**: Testimonials are stored in a custom database table.
- **Shortcode Support**: Easily display the slider on any page or post using a shortcode.

---

## Installation

1. Download the plugin files and upload them to the `/wp-content/plugins/testimonial-slider-pro/` directory, or install the plugin through the WordPress Plugins screen directly.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Upon activation, the plugin automatically creates a custom database table to store testimonials.

---

## Usage

1. **Add Testimonials**: Add testimonials to your WordPress database. (You may need a custom admin interface to input testimonials.)
2. **Display Slider**: Use the `[testimonial_slider]` shortcode to display the testimonial slider anywhere on your website.

---

## Shortcode

### `[testimonial_slider]`
- Use this shortcode to display the testimonial slider on any page or post.

---

## Enqueued Assets

### Admin Panel
- **Bootstrap CSS**: Provides a modern and consistent UI.
- **Custom Admin CSS/JS**: Adds specific styles and functionalities for the admin panel.

### Frontend
- **Swiper.js**: Used for smooth slider functionality.
- **Swiper CSS**: Ensures proper styling of the slider.
- **Custom Swiper Styles/JS**: Allows you to customize the slider’s look and behavior.

---

## How It Works

1. **Database Table**: The plugin creates a custom database table named `<prefix>_testimonials` to store testimonials.
2. **Frontend Slider**: Fetches testimonials from the database and displays them using Swiper.js.
3. **Customizable Controls**: Includes navigation buttons (`Next` and `Prev`) and pagination for better user interaction.

---

## Screenshots

1. **Testimonial Slider Frontend**: 
   ![Frontend Slider Screenshot](assets/screenshots/frontend-slider.png)

2. **Admin Panel**:
   ![Admin Panel Screenshot](assets/screenshots/admin-panel.png)

---

## Development

### Plugin Structure

```
testimonial-slider-pro/
├── assets/
│   ├── css/
│   │   ├── bootstrap.min.css
│   │   ├── custom-admin.css
│   │   └── swiper-style.css
│   ├── js/
│   │   ├── bootstrap.bundle.min.js
│   │   ├── custom-admin.js
│   │   └── swiper-init.js
├── includes/
│   ├── admin/
│   │   └── admin-menu.php
├── testimonial-slider-pro.php
```

---

## Future Enhancements

- Add an admin interface for managing testimonials directly from the WordPress dashboard.
- Support for multiple slider instances on a single page.
- Enhanced styling options and theme compatibility.
- Support for importing/exporting testimonials in bulk.

---

## Changelog

### Version 1.0.0
- Initial release with basic functionality:
  - Testimonial slider using Swiper.js.
  - Admin assets enqueued with Bootstrap.
  - Custom database table for testimonials.

---

## License

This plugin is licensed under the [GPL2 License](https://www.gnu.org/licenses/gpl-2.0.html).

---

## Author

- **Name**: Mihir Das
- **GitHub**: [https://github.com/the-mihir](https://github.com/the-mihir)

---

## Support

For any issues or feature requests, please create an issue on the [GitHub repository](https://github.com/the-mihir/wp-testimonial).
```