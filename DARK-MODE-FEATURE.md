# 🌙 Dark Mode Feature

## Overview
A beautiful, persistent dark mode has been added to the CRAS application. Users can toggle between light and dark themes, and their preference is saved in the browser's localStorage.

## Features

### ✨ **Toggle Button**
- Located in the navbar (top-right corner)
- Moon icon (🌙) for light mode
- Sun icon (☀️) for dark mode
- Smooth icon transitions with hover effects

### 💾 **Persistent Storage**
- User's theme preference is saved in browser localStorage
- Theme persists across page refreshes and sessions
- No database changes required

### 🎨 **Dark Theme Colors**
- **Background**: Deep slate (#0f172a, #1e293b)
- **Cards**: Dark gray (#1e293b)
- **Text**: Light gray (#f1f5f9, #cbd5e1)
- **Headers**: Darker purple (#4c1d95, #5b21b6)
- **Borders**: Subtle gray (#334155)

### 🔄 **Smooth Transitions**
- All color changes have smooth 0.3s transitions
- No jarring switches when toggling themes
- Professional and polished feel

## Implementation Details

### Files Modified:
1. **`resources/views/partials/navbar.blade.php`**
   - Added dark mode toggle button with icon
   - Added JavaScript for theme switching
   - Enhanced navbar with Font Awesome icons

2. **`public/css/dark-mode.css`**
   - Global dark mode styles using CSS variables
   - Theme switching via `[data-theme="dark"]` attribute
   - Covers all UI components (cards, forms, tables, modals)

3. **All Main Pages** (added dark mode CSS link):
   - `resources/views/audit_logs.blade.php`
   - `resources/views/assets/index.blade.php`
   - `resources/views/assessment_sessions/index.blade.php`
   - `resources/views/risk_assessments/index.blade.php`
   - `resources/views/users/index.blade.php`
   - `resources/views/profile/edit.blade.php`

## How It Works

### Theme Switching Logic:
```javascript
1. Check localStorage for saved theme preference
2. If dark mode was previously enabled, apply it on page load
3. When toggle button is clicked:
   - Switch theme attribute on <html> element
   - Update localStorage with new preference
   - Change icon from moon to sun (or vice versa)
```

### CSS Variables:
```css
Light Mode:
- --bg-primary: #ffffff (white)
- --text-primary: #1e293b (dark gray)
- --card-bg: #ffffff (white)

Dark Mode:
- --bg-primary: #0f172a (deep blue-black)
- --text-primary: #f1f5f9 (light gray)
- --card-bg: #1e293b (dark gray)
```

## Usage

### For Users:
1. Look for the moon/sun icon in the top-right corner of the navbar
2. Click the icon to toggle between light and dark modes
3. Your preference is automatically saved

### For Developers:
To add dark mode support to a new page:
1. Add the dark mode CSS link in the `<head>`:
   ```html
   <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
   ```
2. Include the navbar partial (already has the toggle):
   ```blade
   @include('partials.navbar')
   ```
3. The page will automatically support dark mode!

## Customization

### To Change Dark Mode Colors:
Edit `public/css/dark-mode.css` and modify the CSS variables under `[data-theme="dark"]`:

```css
[data-theme="dark"] {
    --bg-primary: #your-color;
    --text-primary: #your-color;
    --card-bg: #your-color;
    /* etc. */
}
```

### To Add Dark Mode to Additional Elements:
Add new rules in `dark-mode.css`:

```css
[data-theme="dark"] .your-element {
    background: var(--card-bg);
    color: var(--text-primary);
}
```

## Browser Compatibility
✅ Chrome/Edge (Latest)
✅ Firefox (Latest)
✅ Safari (Latest)
✅ Opera (Latest)

## Benefits

### For Users:
- 👁️ **Eye Comfort**: Reduced eye strain in low-light environments
- 🌙 **Night Work**: Better for working late at night
- 🎨 **Visual Preference**: Modern, sleek dark aesthetic
- 🔋 **Battery Saving**: Can save battery on OLED screens

### For System:
- 📱 **Modern UX**: Aligns with current design trends
- 🎯 **Accessibility**: Better accessibility for light-sensitive users
- 💼 **Professional**: Shows attention to user experience
- 🚀 **No Backend Changes**: Purely frontend implementation

## Testing Checklist

- [x] Toggle button appears in navbar
- [x] Icon switches between moon and sun
- [x] Dark mode applies to all pages
- [x] Cards and UI elements adapt to theme
- [x] Text remains readable in both modes
- [x] Theme persists after page refresh
- [x] Smooth transitions between themes
- [x] Forms and inputs work in dark mode
- [x] Modals and alerts adapt to theme
- [x] No visual glitches or broken layouts

---

**Last Updated**: July 6, 2026
**Status**: ✅ Fully Implemented & Tested
