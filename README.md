## GitHub Authorization and Repository Information Display

### Objective:

Test your ability to integrate with a third-party API (GitHub), retrieve data, and present it in a user-friendly and
visually appealing way.
<br>

### Task Overview:

- GitHub OAuth Authorization:
    - Implement GitHub OAuth to allow a user to log in with their GitHub account.
    - After successful authentication, retrieve the user’s GitHub profile information and their list of public
      repositories.
      <br><br>
    - Data to Retrieve:

        - From the user profile:
        - Username
        - Profile picture
        - Bio
        - Number of public repositories
          <br><br>
    - **From each repository:**
        - Repository name
        - Description
        - Stars
        - Forks
        - Language
          <br><br>
- UI/UX Requirements:
    - Present the user's profile information at the top in a clean, organized manner (e.g., profile picture, username,
      and
      bio).
    - List the public repositories with the relevant data (name, description, stars, forks, language) below.
    - Make sure the design is responsive and visually appealing. Use a simple, modern layout.
      <br><br>
- Bonus (Optional):
    - Add a **Search** bar that allows users to search/filter repositories by name.
    - Implement **Pagination** if the user has many repositories.
    - Add a button to open each repository in a new tab, linking to the repository on GitHub.
      <br><br>
- Technical Requirements:
    - Use **Laravel** for the backend and handle the GitHub OAuth process.
    - The frontend can be simple but clean. You may use **Blade**, or for a **richer UI**, you can use **Vue.js** or
      **React**.
    - Use GitHub’s official API to fetch user data and
      repositories: [GitHub API Documentation](https://docs.github.com/en/rest).
      <br><br>
- Criteria:
    - **GitHub Integration:** Successful OAuth login and data retrieval using GitHub’s API.
    - **Code Quality**: Clean, well-structured, and maintainable code (PHP and Laravel best practices).
    - **UI/UX**: User-friendly and responsive design that presents the information in a clear, organized manner.
