# Contributing to The Missing Sock Photography Platform

Thank you for your interest in contributing to this project. This repository contains proprietary code for a client, so please review these guidelines carefully.

## Code of Conduct

- Respect the proprietary nature of this codebase
- Do not share client-specific information outside the authorized team
- Maintain professional standards in all communications
- Follow security best practices at all times

## Getting Started

### Prerequisites

Before contributing, ensure you have:
- PHP 8.2 or higher installed
- Composer installed
- Node.js and npm installed
- MySQL or compatible database
- Git configured properly

### Development Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/schoedel-learn/missing-sock-laravel.git
   cd missing-sock-laravel
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database in `.env` and run migrations:
   ```bash
   php artisan migrate --seed
   ```

5. Start development servers:
   ```bash
   php artisan serve
   npm run dev
   ```

## Contribution Workflow

### 1. Branch Naming Convention

Use descriptive branch names following these patterns:

- `feature/description` - For new features
- `fix/description` - For bug fixes
- `docs/description` - For documentation updates
- `refactor/description` - For code refactoring
- `security/description` - For security fixes

Examples:
- `feature/add-payment-gateway`
- `fix/login-validation-error`
- `docs/update-api-endpoints`

### 2. Making Changes

1. **Create a feature branch from `main`:**
   ```bash
   git checkout main
   git pull origin main
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes:**
   - Write clean, well-documented code
   - Follow Laravel and PHP best practices
   - Keep changes focused and minimal
   - Update relevant documentation

3. **Test your changes:**
   ```bash
   # Run PHP tests if available
   php artisan test
   
   # Check for syntax errors
   composer check-syntax
   
   # Test manually in your local environment
   ```

4. **Commit your changes:**
   ```bash
   git add .
   git commit -m "Brief description of changes"
   ```
   
   Use clear, descriptive commit messages:
   - ✅ "Add email validation to pre-order form"
   - ✅ "Fix payment processing timeout issue"
   - ❌ "Update stuff"
   - ❌ "WIP"

5. **Push your branch:**
   ```bash
   git push origin feature/your-feature-name
   ```

### 3. Creating a Pull Request

1. Go to the repository on GitHub
2. Click "New Pull Request"
3. Select your branch as the source
4. Fill out the PR template completely:
   - Clear description of changes
   - Type of change
   - Testing performed
   - Client impact assessment
   - Screenshots (for UI changes)
   - Security considerations

4. Request review from code owners (automatic via CODEOWNERS)

### 4. Code Review Process

- A code owner must approve all PRs
- Address all review comments
- Resolve all conversations before merging
- Ensure all CI checks pass
- Keep PR updated with main branch if needed

### 5. Merging

Once approved:
- Ensure branch is up to date with `main`
- All checks must pass
- All conversations must be resolved
- Merge using the GitHub interface
- Delete the feature branch after merging

## Coding Standards

### PHP / Laravel

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Use Laravel conventions and best practices
- Write meaningful variable and function names
- Add PHPDoc blocks for classes and methods
- Keep methods focused and single-purpose

### JavaScript / Frontend

- Use consistent indentation (2 or 4 spaces)
- Follow Tailwind CSS conventions
- Keep components modular and reusable
- Use Alpine.js sparingly and appropriately
- Comment complex logic

### Database

- Use descriptive migration names
- Always provide `up()` and `down()` methods
- Use foreign keys where appropriate
- Index frequently queried columns
- Test migrations both up and down

## What to Contribute

### Welcome Contributions

- Bug fixes
- Performance improvements
- Code refactoring (with tests)
- Documentation improvements
- Test coverage improvements
- Security fixes

### Discuss First

Please open an issue to discuss before working on:
- Major new features
- Architectural changes
- Breaking changes
- Changes to client-specific logic

## Security

### Reporting Security Issues

**Do not create public issues for security vulnerabilities.**

Instead:
1. Email the repository administrator directly
2. Provide detailed information about the vulnerability
3. Wait for acknowledgment before disclosure

### Security Best Practices

- Never commit sensitive data (API keys, passwords, etc.)
- Always use environment variables for secrets
- Validate all user input
- Use parameterized queries (Eloquent does this by default)
- Keep dependencies up to date
- Follow OWASP security guidelines

## Testing

### Writing Tests

- Write tests for new features
- Update tests when modifying existing features
- Ensure tests are focused and clear
- Use descriptive test method names
- Follow existing test patterns in the codebase

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/PreOrderTest.php

# Run with coverage (if configured)
php artisan test --coverage
```

## Documentation

Update documentation when:
- Adding new features
- Changing existing functionality
- Modifying configuration options
- Adding new environment variables
- Changing deployment procedures

Documentation should be:
- Clear and concise
- Accurate and up-to-date
- Include examples where helpful
- Written for your audience (developers, administrators, etc.)

## Questions?

If you have questions:
1. Check existing documentation first
2. Search closed issues and PRs
3. Ask in your pull request
4. Contact the repository administrator

## License

This is proprietary code for The Missing Sock Photography. By contributing, you agree that your contributions will be licensed under the same proprietary terms.

---

Thank you for contributing responsibly to this project!
