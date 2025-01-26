1. Install the database. You can find the schema in this link.

2. Install Vite.

3. Install Vue.

4. Install Tailwind CSS.

5. Install [Headless UI](https://headlessui.com/) because we need templates and JavaScript with Tailwind CSS.
   - [Tailwind UI](https://tailwindui.com/)
   - [Headless UI](https://headlessui.com/)
   - [Heroicons](https://heroicons.com/)

   ```bash
   npm install -D @headlessui/vue@latest @heroicons/vue @tailwindcss/forms
   ```

6. Install [Laravel Sluggable](https://github.com/spatie/laravel-sluggable) to generate slugs.


sail artisan cache:clear
sail artisan view:clear
sail artisan route:clear
sail artisan clear-compiled
sail artisan config:cache
