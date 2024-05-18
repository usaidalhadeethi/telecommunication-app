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
