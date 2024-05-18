# Personnel Bonus Tracking and Objection System

This project is developed for a telecommunications company to manage the monthly bonuses of customer representatives (assistants). Each assistant reports to a team leader, and the team leaders report to group managers.

## Overview

Assistants handle customer calls at the call center and receive monthly bonuses based on their performance. The system tracks these bonuses and allows assistants to log their calls and file objections if they disagree with their bonuses.

## Key Features

### For Assistants
1. **Log Customer Calls**: Assistants can log calls with details like customer name, call subject, date, start and end times, and status.
2. **View Monthly Bonuses**: Assistants can view their monthly bonus list and file objections.
3. **File Objections**: Assistants can submit objections to their bonuses, which are sent to their team leaders for review.

### For Team Leaders
1. **Review Objections**: Team leaders can view and respond to objections from their assistants, either approving or rejecting them. The status of objections is updated and an email is sent to the group manager.

## Bonus Calculation

- **Base Bonus**: 5000 TL per month.
- **Performance-Based Adjustments**:
  - No bonus for handling fewer than 100 calls/day.
  - Additional bonus for handling 100-199 calls/day:
    ```
    Base Bonus + (Number of calls ≤ 5 minutes) × 1.25
    ```
  - Additional bonus for handling 200+ calls/day:
    ```
    Base Bonus + (Number of calls ≤ 5 minutes) × 2
    ```

This system ensures transparent tracking of bonuses and provides a structured process for handling objections.

![Screenshot 2024-05-18 213732](https://github.com/usaidalhadeethi/telecommunication-app/assets/101979002/34135460-080f-464a-9cbe-9be6ccae9b5c)
![Screenshot 2024-05-18 213751](https://github.com/usaidalhadeethi/telecommunication-app/assets/101979002/40efea0a-b377-4258-8405-ee40f1c72e20)
![Screenshot 2024-05-18 213913](https://github.com/usaidalhadeethi/telecommunication-app/assets/101979002/632a3a0e-d00e-4db3-bb9d-7946b7df6d15)
![Screenshot 2024-05-18 215005](https://github.com/usaidalhadeethi/telecommunication-app/assets/101979002/25be5776-ecfb-4cb6-934e-05fae08717e7)
