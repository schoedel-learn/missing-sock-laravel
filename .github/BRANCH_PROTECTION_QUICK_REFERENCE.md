# Branch Protection Quick Reference

## 🚀 Quick Setup (5 Minutes)

### Step 1: Enable Branch Protection
1. Go to: https://github.com/schoedel-learn/missing-sock-laravel/settings/branches
2. Click **"Add rule"** or **"Add branch protection rule"**
3. Branch name pattern: `main`

### Step 2: Check These Settings
✅ **Require pull request reviews before merging** (at least 1 approval)  
✅ **Require review from Code Owners**  
✅ **Require status checks to pass** (select "PR Validation" if available)  
✅ **Require branches to be up to date before merging**  
✅ **Require conversation resolution before merging**  
✅ **Do not allow bypassing the above settings**  
❌ **Allow force pushes** - UNCHECK THIS  
❌ **Allow deletions** - UNCHECK THIS

### Step 3: Save
Click **"Create"** at the bottom of the page.

---

## 📋 Daily Workflow

### Making Changes
```bash
# 1. Create feature branch
git checkout main
git pull origin main
git checkout -b feature/my-feature

# 2. Make changes and commit
git add .
git commit -m "Description of changes"

# 3. Push to GitHub
git push origin feature/my-feature

# 4. Create PR on GitHub
# 5. Wait for approval
# 6. Merge via GitHub
```

### DO NOT
❌ `git push origin main` - Direct push will be blocked  
❌ `git push --force` - Force push will be blocked  
❌ Commit sensitive data (.env, passwords, API keys)

### DO
✅ Always work in feature branches  
✅ Create descriptive PRs with the template  
✅ Wait for review before merging  
✅ Test locally before pushing

---

## 🔒 Security Checklist

Before making repository public:
- [ ] Branch protection enabled on `main`
- [ ] CODEOWNERS file in place (@schoedel-learn)
- [ ] All sensitive data removed from history
- [ ] .env file in .gitignore
- [ ] No API keys or passwords in code
- [ ] Dependabot alerts enabled
- [ ] Only authorized collaborators have access

---

## 📞 Emergency Contacts

**Repository Owner:** @schoedel-learn

**For Security Issues:** Email administrator directly (do not create public issue)

---

## 🔗 Full Documentation

For detailed information, see:
- [BRANCH_PROTECTION_GUIDE.md](../BRANCH_PROTECTION_GUIDE.md) - Complete setup guide
- [CONTRIBUTING.md](../CONTRIBUTING.md) - Contribution workflow
- [README.md](../README.md#repository-management-and-branch-protection) - Project overview

---

## ⚡ Common Issues

**"I can't push to main"**  
→ This is correct! Create a feature branch and PR.

**"My PR can't be merged"**  
→ Check: approval received, checks passing, conflicts resolved.

**"How do I update my branch?"**  
```bash
git checkout feature/my-branch
git fetch origin
git merge origin/main
git push
```
