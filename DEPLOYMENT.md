# Image Storage Configuration

This application supports both local development and AWS S3 cloud storage for image uploads.

## Local Development

For local development, images are stored in the `public` disk and served via the Laravel storage symlink.

## Production/AWS S3 Setup

### Laravel Cloud
If you're using Laravel Cloud, S3 is automatically configured:
- The `LARAVEL_CLOUD_DISK_CONFIG` environment variable indicates Laravel Cloud is managing storage
- AWS credentials and bucket configuration are handled automatically
- No manual environment variable setup needed

### Other Production Environments
To configure AWS S3 storage for other production environments:

1. **Set Environment Variables:**
   ```bash
   # AWS Credentials
   AWS_ACCESS_KEY_ID=your_access_key_id_here
   AWS_SECRET_ACCESS_KEY=your_secret_access_key_here
   AWS_DEFAULT_REGION=your_region_here
   AWS_BUCKET=your_bucket_name_here
   
   # Optional: Custom S3 URL or endpoint
   AWS_URL=https://your_bucket_name_here.s3.your_region_here.amazonaws.com
   AWS_ENDPOINT=
   
   # Switch to cloud storage for production
   FILESYSTEM_DISK=cloud
   ```

2. **AWS S3 Bucket Configuration:**
   - Create an S3 bucket in your AWS account
   - Set appropriate permissions for public read access to uploaded images
   - Configure CORS if accessing from a different domain
   - Consider setting up CloudFront CDN for better performance

3. **Laravel Configuration:**
   - The `cloud` disk is automatically configured to use S3
   - Images are uploaded with public visibility
   - URLs are generated using S3's public URL format

## How It Works

- **Development:** `APP_ENV=local` → Uses `public` disk (local storage)
- **Laravel Cloud:** `LARAVEL_CLOUD_DISK_CONFIG` present → Uses Laravel Cloud's managed S3 configuration
- **Other Production:** `APP_ENV=production` → Uses `cloud` disk (manually configured AWS S3)
- The ImageService automatically detects the environment and switches storage methods
- URLs are generated appropriately for each storage type

## Required AWS Permissions

Your AWS IAM user/role needs the following S3 permissions:
- `s3:PutObject`
- `s3:PutObjectAcl`
- `s3:GetObject`
- `s3:DeleteObject`

## Testing

Test the image upload functionality after configuring AWS credentials to ensure images are properly uploaded and URLs are accessible.