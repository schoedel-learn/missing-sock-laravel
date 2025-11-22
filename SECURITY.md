# Security Policy

## Repository Security

This repository contains proprietary code for The Missing Sock Photography. While the repository is public, the `main` branch is protected to ensure code quality and prevent unauthorized changes.

## Reporting Security Vulnerabilities

**⚠️ DO NOT create public issues for security vulnerabilities.**

If you discover a security vulnerability in this codebase:

1. **Do not disclose publicly** - This includes GitHub issues, discussions, or social media
2. **Contact the repository administrator** - Use GitHub's private vulnerability reporting feature or contact @schoedel-learn directly through their GitHub profile
3. **Include detailed information:**
   - Description of the vulnerability
   - Steps to reproduce
   - Potential impact
   - Suggested fix (if you have one)
4. **Wait for acknowledgment** before any public disclosure

We take all security reports seriously and will respond as quickly as possible.

## Security Best Practices for Contributors

### Never Commit Sensitive Data

❌ **DO NOT commit:**
- Environment files (`.env`)
- API keys or tokens
- Database passwords
- Private keys or certificates
- Client personal information
- Payment gateway credentials
- Session secrets

✅ **DO:**
- Use `.env.example` for documentation
- Store secrets in environment variables
- Use Laravel's built-in encryption
- Keep `.env` in `.gitignore`

### Code Security

When contributing code:

✅ **Do:**
- Validate all user input
- Use parameterized queries (Eloquent ORM)
- Sanitize output to prevent XSS
- Use Laravel's CSRF protection
- Keep dependencies up to date
- Follow OWASP security guidelines
- Use strong authentication methods

❌ **Avoid:**
- Raw SQL queries without parameters
- Exposing sensitive data in responses
- Weak password requirements
- Unvalidated file uploads
- Client-side only validation
- Hardcoded credentials

### Dependency Security

- Keep composer and npm dependencies updated
- Review security advisories from Dependabot
- Test updates in development before production
- Use `composer audit` and `npm audit` regularly

### Access Control

- Follow the principle of least privilege
- Use Laravel's authorization features
- Implement role-based access control (RBAC)
- Log security-relevant events
- Review access logs regularly

## Security Features Enabled

This repository has the following security features:

### GitHub Security Features
- ✅ Branch protection on `main`
- ✅ Required reviews via CODEOWNERS
- ✅ Secret scanning (automatic for public repos)
- ✅ Dependabot security alerts
- ✅ PR validation checks

### Application Security Features
- ✅ Laravel's built-in security features
- ✅ CSRF protection
- ✅ Password hashing (bcrypt)
- ✅ SQL injection protection (Eloquent ORM)
- ✅ XSS protection (Blade templating)
- ✅ Secure session management
- ✅ Environment-based configuration

## Security Checklist for Deployments

Before deploying to production:

- [ ] All environment variables are properly configured
- [ ] `.env` file is not accessible via web
- [ ] Debug mode is disabled (`APP_DEBUG=false`)
- [ ] HTTPS is enforced
- [ ] Database credentials are secure
- [ ] Stripe is in production mode with live keys
- [ ] File permissions are properly set (no 777)
- [ ] Error messages don't expose sensitive information
- [ ] Backup procedures are in place
- [ ] Security headers are configured
- [ ] Rate limiting is enabled
- [ ] Queue workers are properly secured

## Monitoring and Response

### Security Monitoring

We monitor for:
- Unusual access patterns
- Failed authentication attempts
- Suspicious database queries
- Unauthorized access attempts
- Dependency vulnerabilities
- Code scanning alerts

### Incident Response

In case of a security incident:

1. **Assess** the scope and impact
2. **Contain** the issue immediately
3. **Investigate** the root cause
4. **Remediate** the vulnerability
5. **Document** the incident and response
6. **Notify** affected parties if required
7. **Review** and improve security measures

## Third-Party Services

This application integrates with:

- **Stripe** (Payment processing) - PCI DSS compliant
- **SendGrid** (Email) - Use API keys with minimal permissions
- **AWS/Cloud Services** (if applicable) - Follow cloud security best practices

Ensure all third-party API keys are:
- Stored as environment variables
- Rotated regularly
- Limited to necessary permissions
- Monitored for unusual activity

## Compliance

This codebase handles:
- Customer personal information
- Payment card information (via Stripe, not stored directly)
- Children's information (school photos)

Ensure compliance with:
- GDPR (if applicable)
- CCPA (California customers)
- COPPA (Children's Online Privacy Protection Act)
- PCI DSS (Payment Card Industry Data Security Standard)

## Security Updates

Security updates are prioritized and deployed quickly:

1. Critical vulnerabilities: Within 24 hours
2. High severity: Within 1 week
3. Medium/Low severity: Next regular deployment

## Additional Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Documentation](https://laravel.com/docs/security)
- [Stripe Security](https://stripe.com/docs/security/stripe)
- [GitHub Security Best Practices](https://docs.github.com/en/code-security)

## Questions?

For security questions or concerns, contact the repository administrator.

---

**Remember:** Security is everyone's responsibility. When in doubt, ask before proceeding.
