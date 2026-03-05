import { ref } from "vue";

const API_URL = "http://localhost:8000/Getter.php";

export function useTeachers() {
  const teachers = ref([]);
  const count = ref(0);
  const isLoading = ref(false);
  const error = ref(null);

  async function getTeachers(userId) {
    try {
      isLoading.value = true;

      const response = await fetch(API_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "getTeachers", id: userId }),
      });

      const result = await response.json();

      if (result.success) {
        teachers.value = result.teachers.map((teacher) => ({
          id: teacher.id,
          firstname: teacher.firstname,
          lastname: teacher.lastname,
          subject: teacher.subject,
          quarter: teacher.quarter,
          year: teacher.year,
          sentiment: teacher.sentiment,
          email: teacher.email,
        }));

        count.value = result.total;
        isLoading.value = false;
      } else {
        console.error("Error fetching teacher data", result.message);
        isLoading.value = false;
      }
    } catch (error) {
      console.error("Error fetching teacher data:", error);
    } finally {
      isLoading.value = false;
    }
  }
  return { teachers, count, isLoading, error, getTeachers };
}
