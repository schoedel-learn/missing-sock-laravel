# Branch Protection Guide

## Overview

This document provides step-by-step instructions for protecting the `main` branch of this repository. Since this is a public repository containing client-specific customizations for The Missing Sock Photography, it's critical to prevent unauthorized or accidental changes to the main branch.

## Why Branch Protection Matters

This repository contains:
- Proprietary client customizations
- Production-ready code for a live business
- Sensitive configuration and workflow logic

Branch protection ensures:
- All changes go through a review process
- Code quality standards are maintained
- Accidental force pushes or deletions are prevented
- A clear audit trail of all changes

## Setting Up Branch Protection

### Step 1: Navigate to Branch Protection Settings

1. Go to the repository on GitHub: https://github.com/schoedel-learn/missing-sock-laravel
2. Click on **Settings** (you must be a repository administrator)
3. In the left sidebar, click **Branches**
4. Under "Branch protection rules", click **Add rule** or **Add branch protection rule**

### Step 2: Configure the Protection Rule

In the "Branch name pattern" field, enter: `main`

#### Recommended Protection Settings

Check the following options:

**Protect matching branches:**

✅ **Require a pull request before merging**
   - ✅ Require approvals: **1** (or more if you have multiple maintainers)
   - ✅ Dismiss stale pull request approvals when new commits are pushed
   - ✅ Require review from Code Owners

✅ **Require status checks to pass before merging**
   - ✅ Require branches to be up to date before merging
   - Select any CI/CD checks you have configured (if applicable)

✅ **Require conversation resolution before merging**
   - Ensures all PR comments are addressed

✅ **Require linear history**
   - Prevents merge commits, maintains clean history

✅ **Do not allow bypassing the above settings**
   - Even administrators must follow these rules

✅ **Restrict who can push to matching branches**
   - Limit to repository administrators only
   - Or specify trusted collaborators

✅ **Allow force pushes** - ❌ **UNCHECK THIS**
   - Prevents rewriting history on main branch

✅ **Allow deletions** - ❌ **UNCHECK THIS**
   - Prevents accidental deletion of main branch

### Step 3: Save the Protection Rule

Click **Create** or **Save changes** at the bottom of the page.

## Working with Protected Branches

### Development Workflow

1. **Never commit directly to `main`**
   ```bash
   # Create a feature branch
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes and commit**
   ```bash
   git add .
   git commit -m "Description of changes"
   ```

3. **Push your branch**
   ```bash
   git push origin feature/your-feature-name
   ```

4. **Create a Pull Request**
   - Go to GitHub and create a PR from your feature branch to `main`
   - Fill out the PR template with details about your changes
   - Request review from a code owner

5. **Address Review Feedback**
   - Make requested changes
   - Push additional commits to the same branch
   - Respond to comments

6. **Merge**
   - Once approved and all checks pass, merge the PR
   - Delete the feature branch after merging

### Emergency Situations

If you absolutely must make an urgent change:

1. **Still create a PR** - branch protection helps prevent mistakes even in emergencies
2. **Self-review carefully** - if you're the only admin, review your own changes thoroughly
3. **Document the urgency** - explain in the PR why it couldn't wait for normal review
4. **Follow up** - have someone review the change after the fact

## Code Owners

This repository includes a `.github/CODEOWNERS` file that automatically requests reviews from designated maintainers. The current code owner is the repository administrator.

If you need to add or modify code owners, edit `.github/CODEOWNERS`.

## Managing Collaborators

### Adding Trusted Collaborators

1. Go to **Settings** → **Collaborators and teams**
2. Click **Add people**
3. Assign appropriate permissions:
   - **Read**: Can view and clone, cannot push
   - **Write**: Can push to non-protected branches, must use PRs for protected branches
   - **Admin**: Full access including settings

### Recommended Permissions for Client Projects

- **Client stakeholders**: Read access (can view progress)
- **External developers**: Write access (can create PRs)
- **Core maintainers**: Admin access (can manage settings and approve PRs)

## Additional Security Measures

### 1. Enable Security Features

- Go to **Settings** → **Code security and analysis**
- Enable:
  - Dependabot alerts
  - Dependabot security updates
  - Secret scanning (for public repos, this is automatic)

### 2. Review Access Regularly

- Periodically audit who has access: **Settings** → **Collaborators and teams**
- Remove access for anyone who no longer needs it

### 3. Use Protected Tags for Releases

Consider protecting release tags to prevent tampering:
- Go to **Settings** → **Tags** → **Protected tags**
- Add a rule like `v*` to protect version tags

### 4. Monitor Repository Activity

- Check the **Insights** → **Security** tab regularly
- Review the **Pulse** page to see recent activity
- Set up notifications for important events

## Pull Request Best Practices

### Creating Quality PRs

1. **Use descriptive titles**: "Add user authentication" not "Fix stuff"
2. **Fill out the PR template completely**
3. **Keep PRs focused**: One feature or fix per PR
4. **Include context**: Why is this change needed?
5. **Reference issues**: Link to related issue numbers
6. **Add screenshots**: For UI changes, include before/after images

### Reviewing PRs

As a reviewer, check:
- ✅ Code follows project conventions
- ✅ No security vulnerabilities introduced
- ✅ Tests pass (if applicable)
- ✅ Documentation is updated
- ✅ No sensitive data (credentials, API keys) committed
- ✅ Changes are minimal and focused

## Troubleshooting

### "I can't push to main"

**This is expected behavior.** Use the workflow above to create a feature branch and PR.

### "My PR can't be merged"

Check that:
- All required reviews are approved
- All status checks pass
- All conversations are resolved
- Branch is up to date with main

### "I need to update my branch with main"

```bash
git checkout main
git pull origin main
git checkout your-feature-branch
git merge main
# Resolve any conflicts
git push origin your-feature-branch
```

Or use rebase for a cleaner history:
```bash
git checkout your-feature-branch
git fetch origin
git rebase origin/main
# Resolve any conflicts
git push --force-with-lease origin your-feature-branch
```

## Summary

Branch protection is essential for maintaining the integrity of this client repository. While it adds a step to the development process, it prevents costly mistakes and ensures code quality.

**Key Points:**
- ✅ Always work in feature branches
- ✅ Always create pull requests
- ✅ Always get code reviews
- ✅ Never force push to main
- ✅ Keep the main branch deployable at all times

For questions about branch protection or this guide, contact the repository administrator.
