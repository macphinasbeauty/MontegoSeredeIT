# Fix Register Modal Forms

## Information Gathered
- Register forms in `resources/views/components/modal-popup.blade.php` have incorrect action: `{{url('index')}}` instead of `{{ route('register') }}`
- Forms are missing `method="POST"` and `@csrf` for security
- Input fields lack `name` attributes required for form submission
- Email input type is inconsistent (some `text`, should be `email`)
- Controller expects: name, email, password, password_confirmation

## Plan
- Update all register modal forms in `modal-popup.blade.php` for routes: index, index-3, index-4, index-5, index-6, hotel-grid, hotel-list, hotel-map
- Change action to `{{ route('register') }}`
- Add `method="POST"`
- Add `@csrf`
- Add `name` attributes to inputs: name="name", name="email", name="password", name="password_confirmation"
- Ensure email input has `type="email"`

## Dependent Files
- `resources/views/components/modal-popup.blade.php`

## Followup Steps
- Test registration functionality after changes
- Verify CSRF protection is working
