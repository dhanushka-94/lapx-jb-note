# SMS Notifications Setup

This application uses Notify.lk to send SMS notifications to customers when:
1. A new job is created
2. A job status is changed

## Setup Instructions

### 1. Sign up for a Notify.lk account
- Go to [Notify.lk](https://notify.lk/) and create an account
- Purchase credits for sending SMS

### 2. Get your API credentials
- Login to your Notify.lk account
- Go to the Settings page
- Note your User ID and API Key
- Create a Sender ID or use the default "NotifyDEMO" for testing

### 3. Configure the application
- Open your `.env` file
- Update the following values:
  ```
  NOTIFY_USER_ID=your_user_id
  NOTIFY_API_KEY=your_api_key
  NOTIFY_SENDER_ID=your_sender_id
  ```

### 4. Test the integration
- Create a new job with a customer who has a valid phone number
- Check if the customer receives an SMS notification
- Update the job status and verify the status change notification is sent

## SMS Message Templates

### Job Creation
```
Dear {customer_name}, your service job #{job_number} has been created. 
We will keep you updated on its progress. Thank you for choosing our service. - Laptop Expert Service Center
```

### Status Updates
```
Dear {customer_name}, your service job #{job_number} status has been updated to {new_status}. 
[Additional status-specific message] - Laptop Expert Service Center
```

Different status updates include additional information:
- **Completed**: "Your device is ready for pickup. Thank you for your patience."
- **Waiting for Parts**: "We are waiting for parts to arrive. We'll update you once they're in."
- **Delivered**: "Your device has been delivered. Thank you for choosing our service."

## Troubleshooting

If SMS notifications are not being sent:

1. Check if the customer has a valid phone number in the system
2. Verify your Notify.lk API credentials in the `.env` file
3. Make sure you have sufficient credits in your Notify.lk account
4. Check the application logs for any errors related to SMS sending
5. Verify that the Notify.lk service is operational

## Phone Number Format

The system will automatically format phone numbers to comply with Notify.lk requirements:
- Leading zeroes are removed
- Country code (94 for Sri Lanka) is added if not present
- All non-numeric characters are removed

For example:
- `0771234567` will be converted to `94771234567`
- `+94771234567` will be converted to `94771234567` 