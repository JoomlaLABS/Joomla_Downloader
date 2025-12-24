# Joomla! Downloader

![image Joomla! Downloader](https://github.com/user-attachments/assets/aada9cab-5be7-43d8-801f-f113d175139d)

![GitHub all releases](https://img.shields.io/github/downloads/JoomlaLABS/Joomla_Downloader/total?style=for-the-badge&color=blue)
![GitHub release (latest by SemVer)](https://img.shields.io/github/downloads/JoomlaLABS/Joomla_Downloader/latest/total?style=for-the-badge&color=blue)
![GitHub release (latest by SemVer)](https://img.shields.io/github/v/release/JoomlaLABS/Joomla_Downloader?sort=semver&style=for-the-badge&color=blue)

[![License](https://img.shields.io/badge/license-GPL%202.0%2B-green.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)

## 📖 Description

**Joomla! Downloader** is a smart, single-file PHP script that revolutionizes the Joomla! installation process. Built to save time and simplify deployment, it automatically downloads and installs the latest version of Joomla! directly on your server with just one click - no FTP uploads, no manual downloads, no waiting.

Perfect for site administrators, developers, and testers who want to save time and have instant access to all Joomla! versions including stable releases, release candidates, and nightly builds directly from official Joomla! update servers.

## 🚀 Why Use Joomla! Downloader?

### Save Time ⏱️
The traditional Joomla installation process is time-consuming and involves multiple manual steps:
1. Visit the Joomla website to check the latest version
2. Download the package to your local computer
3. Wait for the download to complete
4. Extract the ZIP file locally
5. Upload hundreds of files via FTP to your server
6. Wait for the upload to complete (can take several minutes)

**With Joomla! Downloader**, all these steps are replaced by a single click! The script:
- Automatically downloads the latest version directly from Joomla's official servers to your hosting server
- Extracts the files instantly on your server
- Eliminates slow FTP uploads
- **Reduces installation time from 15-30 minutes to less than 1 minute**

### Always Up-to-Date 🔄
- **Guaranteed latest version**: The script automatically fetches the most recent Joomla release from official update servers
- **No manual checking needed**: Forget about visiting the Joomla website to verify versions
- **Automatic version detection**: The script displays all available versions with detailed information (PHP requirements, database compatibility, release date)
- **Update notifications**: Built-in version checker that alerts you when a new version of the downloader script is available

### Multiple Release Channels 🎯

Unlike the standard download process, Joomla! Downloader gives you instant access to:

#### **Stable Releases** 📦
- **Latest Stable**: The most recent production-ready Joomla version
- **Long-Term Support (LTS) Versions**: Access to actively maintained LTS releases (e.g., Joomla 5.x while still supported)
- **Previous Major Versions**: Available as long as they receive official support from the Joomla project

#### **Testing & Pre-Release** 🧪
Perfect for developers and testers who want to:
- Test upcoming features before official release
- **Release Candidates (RC)**: Pre-release versions for final testing
- **Alpha/Beta versions**: Early access to new features
- Verify extension compatibility with future Joomla versions
- Report bugs before stable release

#### **Nightly Builds** 🌙
Essential for Joomla core developers and advanced testers:
- **Nightly Major**: Development version of the next major release (e.g., from 5.x to 6.x)
- **Nightly Minor**: Development version of the next minor release (e.g., from 5.1 to 5.2)
- **Nightly Patch**: Development version of the next patch release (e.g., from 5.2.1 to 5.2.2)
- Updated daily with the latest code changes
- Test cutting-edge features before anyone else

## ✨ Key Features

### Smart Package Detection
- Connects to official Joomla update servers (update.joomla.org, downloads.joomla.org)
- Automatically identifies the latest version for each release channel
- Displays comprehensive package information:
  - Version number and branch
  - Stability level (Stable, RC, Alpha)
  - Minimum PHP version required
  - Supported databases (MySQL, MariaDB, PostgreSQL) with version requirements
  - Direct download URL

### Enhanced Security 🔒
- **Input validation**: Strict whitelisting of allowed server parameters
- **Domain authorization**: Downloads only from official Joomla domains
- **Path validation**: Protection against directory traversal attacks
- **URL verification**: Multiple validation layers before download
- **Safe extraction**: Security checks during ZIP file extraction
- **Automatic cleanup**: Removes installer files after completion

### Intelligent URL Handling 🌐
- **Multi-pattern URL resolution**: Tests multiple URL formats for maximum compatibility
- **Fallback mechanisms**: Automatically tries alternative URLs if primary fails
- **GitHub release support**: Handles GitHub-hosted packages with redirect management
- **HTTP status validation**: Accepts both 200 (OK) and 302 (Found) responses

### User-Friendly Interface 🎨
- **Visual indicators**: Color-coded cards for different release types
  - 🟢 Green: Stable releases
  - 🔵 Blue: Test/RC versions
  - 🟡 Yellow: Nightly builds
- **Icon system**: Distinctive icons for each package type
- **Responsive design**: Works perfectly on desktop, tablet, and mobile
- **Bootstrap 5**: Modern, clean interface with dark mode support
- **One-click installation**: Simple button click to start installation

### Developer-Friendly 📝
- **Open source**: Freely available on GitHub
- **Self-updating**: Built-in mechanism to check for script updates
- **Self-deleting**: Option to remove the script after installation
- **No dependencies**: Works with standard PHP installation (PHP 7.4+)
- **Detailed error messages**: Clear feedback for troubleshooting

## 🎯 Perfect For

- **Site Administrators**: Quick Joomla installations without FTP hassle
- **Developers**: Instant access to test versions and nightly builds
- **Testers**: Easy testing of pre-release versions
- **Hosting Providers**: Simplified Joomla deployment for clients
- **Students & Learners**: Fast setup for Joomla development environments

## 📊 Comparison: Traditional vs Joomla! Downloader

| Step | Traditional Method | Joomla! Downloader |
|------|-------------------|-------------------|
| Check latest version | Manual website visit | ✅ Automatic |
| Download to local PC | 3-5 minutes | ❌ Not needed |
| Extract locally | 30-60 seconds | ❌ Not needed |
| FTP upload | 10-20 minutes | ❌ Not needed |
| Server extraction | Manual | ✅ Automatic |
| Access to RC/Nightly | ❌ Difficult | ✅ One click |
| **Total Time** | **15-30 minutes** | **< 1 minute** |

## 🔧 How It Works

1. **Upload**: Place `joomla_downloader.php` in your server's public directory
2. **Access**: Open the script in your web browser
3. **Choose**: Select your desired Joomla version from the visual cards
4. **Install**: Click the "Install" button
5. **Done**: Joomla is downloaded, extracted, and ready to configure!

The script automatically:
- Downloads the selected package directly to your server
- Extracts all files to the current directory
- Removes the downloaded ZIP file
- Offers to self-delete for security

## 🆚 Advantages Over Traditional Installation

### Speed & Efficiency
- **10-30x faster** than traditional FTP upload methods
- **Server-to-server transfer** at full datacenter speeds (often 100+ Mbps)
- **No local bandwidth consumption** - your internet speed doesn't matter
- **Instant extraction** on the server's filesystem

### Reliability
- **Direct from official sources** - guaranteed authentic packages
- **No corrupted downloads** - downloads happen server-side with better reliability
- **No FTP errors** - eliminates common FTP timeout and permission issues
- **Atomic operations** - download completes fully before extraction

### Convenience
- **No FTP client needed** - everything happens through your web browser
- **No local storage required** - no need to store large ZIP files on your computer
- **Works from anywhere** - install Joomla from mobile devices or tablets
- **Multiple versions available** - switch between stable, RC, and nightly builds easily

### For Developers & Testers
- **Instant access to nightly builds** - test tomorrow's features today
- **Easy version switching** - quickly deploy different Joomla versions for testing
- **RC version testing** - help improve Joomla by testing pre-release versions
- **No repository cloning needed** - get development versions without Git

## 🔐 Security Features

- Whitelist-based server parameter validation
- Domain authorization for downloads (only official Joomla sources)
- Input sanitization for all user parameters
- Path traversal protection during extraction
- Safe file handling with comprehensive validation
- Automatic cleanup of temporary files
- Optional self-deletion after installation

## 📋 Requirements

- PHP 7.4 or higher
- PHP ZipArchive extension enabled
- `allow_url_fopen` enabled (for downloading packages)
- Write permissions in the installation directory

## 🌟 Use Cases

### Quick Development Setup
Perfect for developers who frequently need fresh Joomla installations:
```
1. Upload joomla_downloader.php to new directory
2. Select "Latest Stable"
3. Install in < 60 seconds
4. Start developing immediately
```

### Testing Pre-Release Versions
Help improve Joomla by testing Release Candidates:
```
1. Access the script
2. Select "Release Candidate" card
3. Test new features before official release
4. Report bugs to help the community
```

### Nightly Build Testing
For Joomla core contributors and advanced developers:
```
1. Choose appropriate nightly build (major/minor/patch)
2. Install latest development code
3. Test cutting-edge features
4. Contribute to Joomla development
```

## 📚 Version Information Display

Each available version displays:
- **Version number**: Full semantic version (e.g., 5.2.1)
- **Branch**: Release branch (e.g., 5.x, 4.x)
- **Stability**: Stable, RC, Alpha, Beta
- **PHP requirement**: Minimum PHP version needed
- **Database compatibility**: Supported databases and versions
- **Download URL**: Direct link to package
- **Info URL**: Link to release notes or announcements

## 🎓 Educational Value

Great for learning Joomla development:
- **Test different versions** easily
- **Explore new features** in RC/nightly builds
- **Learn update process** by comparing versions
- **Practice installation** without time-consuming downloads

## 💡 Pro Tips

1. **Bookmark the script** - Keep it handy for quick installations
2. **Test RC versions** - Help the Joomla community by testing pre-releases
3. **Use nightly builds** for extension compatibility testing
4. **Keep script updated** - Built-in update checker shows when new versions are available
5. **Delete after use** - Use the self-delete feature for security

## 🤝 Contributing

We welcome contributions! Here's how you can help:

### 🔄 How to Contribute

1. **🍴 Fork** the repository
2. **🌿 Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **✨ Make** your changes following our coding standards
4. **🧪 Add** tests if applicable
5. **💾 Commit** your changes (`git commit -m 'Add some amazing feature'`)
6. **🚀 Push** to the branch (`git push origin feature/amazing-feature`)
7. **📮 Submit** a pull request

### 📋 Guidelines

- Follow PSR-12 coding standards for PHP code
- Write clear, concise commit messages
- Test your changes thoroughly before submitting
- Update documentation as needed
- Ensure your code is well-documented with inline comments
- Maintain security best practices

## 📄 License

This project is licensed under the **GNU General Public License v2.0** - see the [LICENSE](LICENSE) file for details.

```
GNU GENERAL PUBLIC LICENSE
Version 2, June 1991

Copyright (C) 2023-2025 Joomla!LABS

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## 👥 Project Information

### 🏢 Project Owner

**Joomla!LABS** - [https://joomlalabs.com](https://joomlalabs.com)

[![Email](https://img.shields.io/badge/Email-info%40joomlalabs.com-red?style=for-the-badge&logo=gmail&logoColor=white)](mailto:info@joomlalabs.com)

*Joomla!LABS is the company that owns and maintains this project.*

### 👨‍💻 Contributors

**Luca Racchetti** - Lead Developer

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Luca%20Racchetti-blue?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/razzo/)
[![GitHub](https://img.shields.io/badge/GitHub-Razzo1987-black?style=for-the-badge&logo=github&logoColor=white)](https://github.com/Razzo1987)

*Full-Stack Developer passionate about creating modern, efficient web applications and tools for the Joomla! community*

## 🆘 Support

### 💬 Get Help

Need help? We're here for you!

- 🐛 **Found a bug?** [Open an issue](https://github.com/JoomlaLABS/Joomla_Downloader/issues/new?labels=bug&template=bug_report.md)
- 💡 **Have a feature request?** [Open an issue](https://github.com/JoomlaLABS/Joomla_Downloader/issues/new?labels=enhancement&template=feature_request.md)
- ❓ **Questions?** [Start a discussion](https://github.com/JoomlaLABS/Joomla_Downloader/discussions)

## 💝 Donate

If you find this project useful, consider supporting its development:

[![Sponsor on GitHub](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa?style=for-the-badge&logo=github)](https://github.com/sponsors/JoomlaLABS)
[![Buy me a beer](https://img.shields.io/badge/🍺%20Buy%20me%20a-beer-FFDD00?style=for-the-badge&labelColor=FFDD00&color=FFDD00)](https://buymeacoffee.com/razzo)
[![Donate via PayPal](https://img.shields.io/badge/Donate-PayPal-0070BA?style=for-the-badge&logo=paypal&logoColor=white)](https://www.paypal.com/donate/?hosted_button_id=4SRPUJWYMG3GL)

Your support helps maintain and improve this project!

---

**Made with ❤️ for the Joomla! Community**

**⭐ If this project helped you, please consider giving it a star! ⭐**
