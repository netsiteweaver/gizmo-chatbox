#!/bin/bash
# Quick script to initialize git repository for Gizmo Chat Module

echo "Initializing Git repository for Gizmo Chat Module..."

# Initialize git
git init

# Add all files
git add .

# Create initial commit
git commit -m "Initial release: Gizmo Chat Module v1.0"

echo ""
echo "Repository initialized!"
echo ""
echo "Next steps:"
echo "1. Create repository on GitHub/GitLab"
echo "2. Add remote: git remote add origin <repository-url>"
echo "3. Push: git push -u origin main"
echo ""
echo "To create a release tag:"
echo "  git tag -a v1.0.0 -m 'Release v1.0.0'"
echo "  git push origin v1.0.0"
