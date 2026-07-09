# Deploying CRAS System to Render

This guide will help you deploy the Cybersecurity Risk Assessment System to Render.

## Prerequisites

- GitHub account with your CRAS repository
- Render account (free tier available at https://render.com)
- Your code pushed to GitHub

## Deployment Steps

### Option 1: Using Render Dashboard (Recommended for Beginners)

1. **Sign up/Login to Render**
   - Go to https://render.com
   - Sign in with your GitHub account

2. **Create a New Web Service**
   - Click "New +" button
   - Select "Web Service"
   - Connect your GitHub repository: `auharo0/cybersecurity-risk-assessment-system`

3. **Configure the Web Service**
   - **Name:** `cras-system` (or your preferred name)
   - **Environment:** `Docker`
   - **Region:** Choose closest to your location
   - **Branch:** `main`
   - **Dockerfile Path:** `./Dockerfile`
   - **Plan:** Free (or paid for better performance)

4. **Create MySQL Database First**
   - Before deploying the web service, click "New +" → "MySQL"
   - **Name:** `cras-db`
   - **Database:** `cras_system`
   - **Plan:** Free
   - Click "Create Database"
   - Wait for it to be ready (2-3 minutes)

5. **Add Environment Variables to Web Service**
   
   After creating the database, add these to your web service:
   
   ```
   APP_NAME=CRAS System
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:GENERATE_THIS_KEY_IN_RENDER
   LOG_CHANNEL=stderr
   LOG_LEVEL=error
   
   DB_CONNECTION=mysql
   DB_HOST=[Get from cras-db database]
   DB_PORT=[Get from cras-db database]
   DB_DATABASE=cras_system
   DB_USERNAME=[Get from cras-db database]
   DB_PASSWORD=[Get from cras-db database]
   
   SESSION_DRIVER=file
   SESSION_LIFETIME=120
   CACHE_DRIVER=file
   QUEUE_CONNECTION=sync
   ```

   **To get database credentials:**
   - Go to your `cras-db` database dashboard
   - Click "Connect" → "Internal Connection String"
   - Copy the values for HOST, PORT, USERNAME, PASSWORD

   **To generate APP_KEY:**
   - After first deployment fails, check logs
   - Or manually generate: `php artisan key:generate --show`

6. **Deploy**
   - Click "Create Web Service"
   - Render will automatically build and deploy
   - First deployment takes 5-10 minutes

7. **Access Your Application**
   - Once deployed, your app will be at: `https://cras-system.onrender.com`
   - Login with default credentials:
     - Email: `admin@cras.com`
     - Password: `password`
   - **IMPORTANT:** Change the default password immediately!

---

### Option 2: Using render.yaml (Automatic)

1. **Push render.yaml to GitHub**
   - The `render.yaml` file is already in your repository
   - This file defines both web service and database

2. **Deploy from Render Dashboard**
   - Go to https://dashboard.render.com
   - Click "New +" → "Blueprint"
   - Select your repository
   - Render will automatically:
     - Create MySQL database
     - Create web service
     - Link them together
     - Set up environment variables

3. **Wait for Deployment**
   - Database creation: ~2-3 minutes
   - Web service build: ~5-10 minutes
   - Total time: ~10-15 minutes

4. **Generate APP_KEY**
   - After first deployment, go to web service dashboard
   - Click "Shell" tab
   - Run: `php artisan key:generate --show`
   - Copy the generated key
   - Add to environment variables: `APP_KEY=base64:YOUR_KEY_HERE`
   - Redeploy

---

## Post-Deployment Steps

### 1. Verify Database Connection
- Check the logs in Render dashboard
- Should see "Running database migrations..."
- Should see "Database seeding completed"

### 2. Test the Application
- Visit your Render URL
- Try logging in with: `admin@cras.com` / `password`
- Create a test risk assessment
- Verify all features work

### 3. Security Steps (IMPORTANT!)

1. **Change Default Password**
   - Login as admin
   - Go to Profile → Change Password
   - Use a strong password

2. **Update APP_KEY**
   - Never use the same APP_KEY as development
   - Generate a new one for production

3. **Verify HTTPS**
   - Render provides free SSL certificates
   - Your app should be at `https://` (secure)

4. **Check Environment Variables**
   - Ensure `APP_DEBUG=false`
   - Ensure `APP_ENV=production`

### 4. Configure Email (Optional)
If you want email notifications to work:
- Add SMTP credentials to environment variables
- Update MAIL_* variables in Render dashboard

---

## Troubleshooting

### Build Failed
- Check build logs in Render dashboard
- Common issues:
  - Missing `composer.json` dependencies
  - Node/npm build errors
  - Docker syntax errors

### Database Connection Failed
- Verify database credentials in environment variables
- Ensure database is running (check database dashboard)
- Check `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### Application Error 500
- Check logs: Go to web service → Logs tab
- Common causes:
  - Missing APP_KEY
  - Database migration failed
  - File permission issues

### Migrations Not Running
- Go to web service → Shell tab
- Manually run: `php artisan migrate --force`
- Run: `php artisan db:seed --force`

### Can't Login
- Check if database was seeded
- Manually create admin user via Shell:
  ```bash
  php artisan tinker
  >>> User::create([
        'name' => 'Admin',
        'email' => 'admin@cras.com',
        'password' => bcrypt('password'),
        'role' => 'administrator',
        'status' => 'active'
      ]);
  ```

---

## Free Tier Limitations

Render's free tier includes:
- ✅ 750 hours/month (enough for one always-on service)
- ✅ Free SSL certificate
- ✅ Automatic deployments from GitHub
- ✅ MySQL database (1GB storage)
- ⚠️ Apps sleep after 15 minutes of inactivity
- ⚠️ First request after sleep takes ~30 seconds (cold start)

To prevent sleeping:
- Upgrade to paid plan ($7/month)
- Use external uptime monitoring service

---

## Updating Your Application

1. **Push changes to GitHub**
   ```bash
   git add .
   git commit -m "Your changes"
   git push origin main
   ```

2. **Automatic Deployment**
   - Render automatically detects changes
   - Rebuilds and redeploys
   - Check deploy logs for progress

3. **Manual Deployment**
   - Go to web service dashboard
   - Click "Manual Deploy" → "Deploy latest commit"

---

## Monitoring

### View Logs
- Go to web service dashboard
- Click "Logs" tab
- Real-time logs appear here

### Check Database
- Go to MySQL database dashboard
- Click "Connect" → "External Connection String"
- Use any MySQL client (like TablePlus, DBeaver)

### Performance Metrics
- Render provides basic metrics
- Monitor response times
- Check error rates

---

## Support

If you encounter issues:
1. Check Render documentation: https://render.com/docs
2. Check Laravel documentation: https://laravel.com/docs
3. Review application logs in Render dashboard
4. Check GitHub repository issues

---

## Estimated Deployment Time

- **Total time:** 15-20 minutes
- Database creation: 2-3 minutes
- Docker build: 8-12 minutes
- Migration & seeding: 1-2 minutes
- First request: 30 seconds (cold start)

Your CRAS system will be live at: `https://your-app-name.onrender.com`

Good luck with your deployment! 🚀
