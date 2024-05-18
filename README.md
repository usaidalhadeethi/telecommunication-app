Personnel Bonus Tracking and Objection System

This project is developed for a telecommunications company to manage the monthly bonuses of customer representatives (assistants). Each assistant reports to a team leader, and the team leaders report to group managers.
Overview

Assistants respond to customer calls received at the call center. They receive monthly bonuses based on the number of calls they handle and the resolution status of these calls.
Assistant/Customer Representative

A screen should be available for assistants to log their interactions with customers. The database should store the following details:

    Assistant ID
    Assistant Full Name
    Customer Full Name
    Call Subject
    Call Date
    Call Start and End Times
    Call Status

Call Subjects:

    Fault
    Request
    Information

Call Statuses:

    Completed
    In Progress
    Unresolved

System Modules

The system provides three modules for assistants and one module for team leaders:
Modules for Assistants

    Customer Call List
    Monthly Bonus List
    Bonus Objections List

1. Customer Call List

When the Customer Call List menu is selected, all calls received by the assistant should be listed. A "New Call" button should be available.

Upon clicking the "New Call" button, a pop-up should appear where the assistant can enter:

    Customer Full Name
    Call Subject
    Call Date
    Call Start and End Times
    Call Status

After clicking the "Save" button, the new entry should appear at the top of the Customer Call List.
2. Monthly Bonus List

Assistants should be able to view their monthly bonus list in this menu. The latest month's bonus should have an "Object" button. Clicking this button should open a pop-up where the assistant can write an objection and submit it.

Once submitted, the objection should be recorded in the system and an email should be sent to the group manager of the team leader.
3. Bonus Objections List (My Objections)

Assistants should be able to see the list of their objections. This list should include:

    Objection Description
    Response from the Team Leader
    Objection Status (Pending, Approved, Rejected)

Module for Team Leaders
Bonus Objections List

Team leaders should be able to see the list of objections raised by their assistants. This list should include:

    Assistant ID
    Assistant Full Name
    Objection Description
    Month of the Objection

For unresolved objections, there should be a "Respond to Objection" button. Clicking this button should open a pop-up where the team leader can write a response and choose to approve or reject the objection.

After submission, the objection status should be updated in the lists for both the team leader and the assistant. Additionally, an email should be sent to the group manager with the objection status.
Bonus Calculation

The monthly base bonus is 5000 TL.

    Assistants who handle less than 100 customer calls per day do not earn a bonus for that day (these calls should not be included in the bonus calculation). The bonus explanation for such days should be "No bonus entitlement".

    For assistants handling 100-200 (exclusive) calls per day:

    javascript

Monthly Base Bonus + (Number of calls with a duration of 5 minutes or less) X 1.25

For assistants handling 200 or more calls per day:

javascript

    Monthly Base Bonus + (Number of calls with a duration of 5 minutes or less) X 2

The "Number of calls with a duration of 5 minutes or less" should be the total for all days in the relevant month.
