# Coolify SSH Key Setup

Your Coolify instance has generated an SSH key for Git repository access.

## SSH Public Key

```
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIEJxAV8LuZLpAViIZRTlV0REoxOpqiSYy61riei8MJFD coolify-generated-ssh-key
```

## Setup Steps

### 1. Add SSH Key to Your Git Provider

#### For GitHub:

1. Go to your repository: `https://github.com/YOUR_USERNAME/YOUR_REPO`
2. Navigate to **Settings** → **Deploy keys**
3. Click **Add deploy key**
4. **Title:** `Coolify Deployment Key`
5. **Key:** Paste the SSH public key above
6. ✅ Check **Allow write access** (if you need Coolify to push)
7. Click **Add key**

#### For GitLab:

1. Go to your project: `https://gitlab.com/YOUR_USERNAME/YOUR_REPO`
2. Navigate to **Settings** → **Repository** → **Deploy Keys**
3. Click **Expand** on "Deploy Keys"
4. **Title:** `Coolify Deployment Key`
5. **Key:** Paste the SSH public key above
6. ✅ Check **Write access** (if needed)
7. Click **Add key**

#### For Bitbucket:

1. Go to your repository
2. Navigate to **Settings** → **Access keys**
3. Click **Add key**
4. **Label:** `Coolify Deployment Key`
5. **Key:** Paste the SSH public key above
6. Click **Add key**

### 2. Configure Coolify Application

1. **Access Coolify Dashboard:** `http://31.97.65.164:8000`
2. Navigate to your application
3. Go to **Source** settings
4. **Repository URL:** Use SSH format:
   - GitHub: `git@github.com:YOUR_USERNAME/YOUR_REPO.git`
   - GitLab: `git@gitlab.com:YOUR_USERNAME/YOUR_REPO.git`
   - Bitbucket: `git@bitbucket.org:YOUR_USERNAME/YOUR_REPO.git`
5. **Branch:** `main`
6. **SSH Key:** Should be automatically detected (or select the Coolify-generated key)

### 3. Test Connection

In Coolify, when you configure the repository:
- It should automatically test the SSH connection
- If successful, you'll see a green checkmark
- If it fails, verify the deploy key was added correctly

## Troubleshooting

### SSH Connection Fails

1. **Verify the key is added correctly:**
   - Check for typos when pasting
   - Ensure no extra spaces or line breaks
   - Make sure it's added as a deploy key, not a user SSH key

2. **Check repository access:**
   - Verify the repository URL is correct
   - Ensure the repository exists and is accessible
   - For private repos, the deploy key must be added

3. **Test SSH connection manually (via SSH to server):**
   ```bash
   ssh -T git@github.com
   # Should respond with: "Hi USERNAME! You've successfully authenticated..."
   ```

### Key Already Exists Error

- If the key already exists in your Git provider, you may need to:
  - Remove the old key first
  - Or use a different key name/label

## Alternative: Use HTTPS with Token

If SSH doesn't work, you can use HTTPS with a personal access token:

1. **Create Personal Access Token** in your Git provider
2. **Repository URL:** Use HTTPS format:
   - `https://github.com/YOUR_USERNAME/YOUR_REPO.git`
3. **Username:** Your Git username
4. **Password/Token:** Your personal access token

## Next Steps

After SSH key is configured:

1. ✅ Deploy key added to Git provider
2. ✅ Repository URL configured in Coolify (SSH format)
3. ✅ Test connection in Coolify
4. ✅ Configure build settings
5. ✅ Set environment variables
6. ✅ Deploy!

---

**Note:** This SSH key is specific to your Coolify instance. Keep it secure and don't share it publicly.

