package main

import (
    "fmt"
    "log"
    "net/http"
    "os/exec"
)

func main() {
    http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
        // Run the git pull command in the specified repository
        cmd := exec.Command("git", "-C", "/home/ubuntu/HNstock", "pull")
        output, err := cmd.CombinedOutput()
        if err != nil {
            log.Printf("Error running git pull: %v", err)
            http.Error(w, "Failed to update repository", http.StatusInternalServerError)
            return
        }

        log.Println("Git pull executed successfully")
        fmt.Fprintf(w, "Git pull output:\n%s", output)
    })

    // Start the server on port 9000
    log.Println("Server started on port 9000")
    if err := http.ListenAndServe(":9000", nil); err != nil {
        log.Fatalf("Failed to start server: %v", err)
    }
}

