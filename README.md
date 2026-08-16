# Enhanced Lesson Plan Creation System

A comprehensive PHP-based web application for creating, managing, and organizing lesson plans with a modern, responsive design.

## Features

- **Create Lesson Plans**: Comprehensive form with all essential fields
- **View & Edit**: Full CRUD operations with intuitive interface
- **Search & Filter**: Find lesson plans by subject, title, or content
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Auto-save**: Automatic saving of form data to prevent data loss
- **Print Support**: Clean print layouts for physical copies
- **Modern UI**: Professional design with smooth animations

## Requirements

To run this system on localhost, you need:

- **PHP 7.4 or higher**
- **Web server** (Apache, Nginx, or built-in PHP server)
- Modern web browser

### Recommended Setup Options:

1. **XAMPP** (Windows/Mac/Linux): https://www.apachefriends.org/
2. **WAMP** (Windows): http://www.wampserver.com/
3. **MAMP** (Mac): https://www.mamp.info/
4. **LAMP** (Linux): Install Apache, PHP manually

## Installation & Setup

### Option 1: Using XAMPP (Recommended)

1. **Download & Install XAMPP**
   - Go to https://www.apachefriends.org/
   - Download XAMPP for your operating system
   - Install with default settings

2. **Start Services**
   - Open XAMPP Control Panel
   - Start **Apache** service
   - MySQL is not required for this system

3. **Copy Files**
   - Copy all project files to: `C:\xampp\htdocs\lesson-plan-system\` (Windows)
   - Or `/Applications/XAMPP/xamppfiles/htdocs/lesson-plan-system/` (Mac)

4. **Access Application**
   - Open browser and go to: `http://localhost/lesson-plan-system/`

### Option 2: Using PHP Built-in Server

1. **Navigate to Project Directory**
   ```bash
   cd /path/to/lesson-plan-system
   ```

2. **Start PHP Server**
   ```bash
   php -S localhost:8000
   ```

3. **Access Application**
   - Open browser and go to: `http://localhost:8000/`

## Usage Guide

### Creating a Lesson Plan

1. Click "Create New Lesson Plan" button
2. Fill in the comprehensive form:
   - **Basic Information**: Title, subject, grade, duration, description
   - **Learning Objectives**: Clear learning goals
   - **Materials**: Required resources and equipment
   - **Lesson Content**: Detailed activities and teaching strategies
   - **Assessment**: Methods to evaluate student learning
   - **Homework**: Follow-up assignments
3. Click "Create Lesson Plan" to save

### Managing Lesson Plans

- **View**: Click "View" to see the complete lesson plan
- **Edit**: Click "Edit" to modify any lesson plan
- **Delete**: Click "Delete" (with confirmation) to remove
- **Search**: Use the search bar to find specific lessons
- **Filter**: Filter by subject using the dropdown
- **Print**: Use the print button for physical copies

### Features Overview

- **Auto-save**: Form data is automatically saved as you type
- **Responsive**: Fully functional on all device sizes
- **Keyboard Shortcuts**:
  - `Ctrl/Cmd + S`: Save current form
  - `Ctrl/Cmd + N`: Create new lesson plan
  - `Escape`: Go back to dashboard
- **Data Persistence**: All data stored in JSON files (no database required)

## File Structure

```
lesson-plan-system/
├── index.php          # Main dashboard
├── create.php         # Create new lesson plan
├── edit.php           # Edit existing lesson plan
├── view.php           # View lesson plan details
├── delete.php         # Delete lesson plan
├── config.php         # Configuration and functions
├── style.css          # Comprehensive styling
├── script.js          # JavaScript functionality
├── data/              # Data storage directory
│   └── lesson_plans.json
└── README.md          # This file
```

## Customization

### Adding New Fields

1. **Update the form** in `create.php` and `edit.php`
2. **Add database handling** in `config.php` functions
3. **Update the view** in `view.php`
4. **Add styling** in `style.css` if needed

### Changing Colors/Theme

Edit the CSS variables in `style.css`:

```css
:root {
    --primary-500: #3b82f6;    /* Change primary color */
    --secondary-500: #14b8a6;  /* Change secondary color */
    --accent-500: #f97316;     /* Change accent color */
}
```

### Database Integration

To use a database instead of JSON files:

1. Create MySQL database and tables
2. Update `config.php` functions to use PDO/MySQLi
3. Add database connection configuration

## Troubleshooting

### Common Issues

1. **"Permission denied" errors**
   - Ensure the `data/` directory is writable
   - On Linux/Mac: `chmod 755 data/`

2. **Pages not loading**
   - Check if Apache/PHP is running
   - Verify file paths are correct
   - Check PHP error logs

3. **Styling not applied**
   - Ensure `style.css` file exists and is accessible
   - Check browser console for errors
   - Clear browser cache

4. **Auto-save not working**
   - Enable JavaScript in browser
   - Check browser console for errors
   - Ensure localStorage is enabled

### Getting Help

1. Check PHP error logs
2. Use browser developer tools
3. Verify file permissions
4. Ensure PHP version compatibility

## Security Notes

For production use, consider:

- Input sanitization (already implemented)
- File permission restrictions
- HTTPS implementation
- Regular backups of data files
- User authentication system

## Future Enhancements

Possible improvements:
- User authentication and roles
- Database integration
- PDF export functionality
- Lesson plan templates
- Collaborative editing
- Version history
- Integration with calendar systems

---

**Built with PHP, HTML5, CSS3, and JavaScript**
**No database required - uses JSON file storage**
**Fully responsive and mobile-friendly**