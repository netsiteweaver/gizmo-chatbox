# Release Checklist

Use this checklist when preparing a new release of Gizmo Chat Module.

## Pre-Release

- [ ] All features are implemented and tested
- [ ] All bugs are fixed
- [ ] Code is reviewed and cleaned up
- [ ] Documentation is up to date
- [ ] CHANGELOG.md is updated with new version
- [ ] Version numbers are updated in code (if applicable)
- [ ] License file is present and correct
- [ ] README.md reflects current version
- [ ] All dependencies are documented

## Testing

- [ ] Tested on PHP 7.4
- [ ] Tested on PHP 8.0+
- [ ] Tested on CodeIgniter 3.1.x
- [ ] Tested database migrations (up and down)
- [ ] Tested widget functionality
- [ ] Tested API endpoints
- [ ] Tested on Chrome
- [ ] Tested on Firefox
- [ ] Tested on Safari
- [ ] Tested on mobile devices (iOS/Android)
- [ ] No JavaScript console errors
- [ ] No PHP errors/warnings
- [ ] No SQL errors

## Documentation

- [ ] README.md is accurate
- [ ] INSTALL.md is up to date
- [ ] API.md is complete
- [ ] CONFIGURATION.md is accurate
- [ ] CHANGELOG.md has all changes
- [ ] Code comments are clear
- [ ] Examples are working

## Repository

- [ ] All files are committed
- [ ] .gitignore is correct
- [ ] No sensitive data in repository
- [ ] No unnecessary files included
- [ ] Repository structure is clean

## Release

- [ ] Create git tag: `git tag -a v1.0.0 -m "Release version 1.0.0"`
- [ ] Push tag: `git push origin v1.0.0`
- [ ] Create GitHub release
- [ ] Upload release notes
- [ ] Attach ZIP archive (optional)
- [ ] Update version badges in README (if using)

## Post-Release

- [ ] Verify GitHub release is live
- [ ] Test installation from repository
- [ ] Monitor for issues
- [ ] Respond to user feedback
- [ ] Plan next release

## Version Numbering

Follow [Semantic Versioning](https://semver.org/):
- **MAJOR** (1.0.0): Breaking changes
- **MINOR** (0.1.0): New features, backward compatible
- **PATCH** (0.0.1): Bug fixes, backward compatible

## Creating a Release

1. Update version in CHANGELOG.md
2. Commit changes: `git commit -m "Prepare release v1.0.0"`
3. Create tag: `git tag -a v1.0.0 -m "Release v1.0.0"`
4. Push commits and tags: `git push && git push --tags`
5. Create release on GitHub with release notes from CHANGELOG

