window.isEmpty = (value) => {
    // Check for null, undefined, or an empty string
    if (value === null || value === undefined || value === "") {
        return true;
    }

    // Check for empty arrays
    if (Array.isArray(value) && value.length === 0) {
        return true;
    }

    // Check for empty objects
    if (typeof value === "object" && !Array.isArray(value)) {
        return Object.keys(value).length === 0;
    }

    // If none of the above conditions are met, return false (not empty)
    return false;
};

window.HTTP_STATUS = {
    UNPROCESSABLE_CONTENT: 422,
    CREATED: 201,
};
