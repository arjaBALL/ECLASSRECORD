/** @format */

export default function useTimeDropdown() {
  const time = [
    { id: 1, name: "7:00-8:30am" },
    { id: 2, name: "8:30-10:00am" },
    { id: 3, name: "10:00-11:30am" },
    { id: 4, name: "11:30-1:00pm" },
    { id: 5, name: "1:00-2:30pm" },
    { id: 6, name: "2:30-4:00pm" },
    { id: 7, name: "4:00-5:30pm" },
    { id: 8, name: "5:30-7:00pm" },
    { id: 9, name: "7:00-8:30pm" },
  ];

  const getSelectedtimeText = (selectedtime) => {
    // Add explicit null/undefined checks
    if (!selectedtime) {
      return "Select Time";
    }

    // Ensure selectedtime is an array
    const safeSelectedTime = Array.isArray(selectedtime) ? selectedtime : [];

    if (safeSelectedTime.length === time.length) {
      return "All Time";
    }

    if (safeSelectedTime.length === 0) {
      return "Select Time";
    }

    return safeSelectedTime
      .map((id) => {
        const foundTime = time.find((slot) => slot.id === id);
        return foundTime ? foundTime.name : "";
      })
      .filter(Boolean)
      .join(", ");
  };

  const selectall = () => {
    return time.map((timeSlot) => timeSlot.id);
  };

  const clearselection = () => {
    return [];
  };

  const loadtime = (callback) => {
    // Simulate API call with error handling
    try {
      setTimeout(() => {
        callback(time);
      }, 500);
    } catch (error) {
      console.error("Error in loadtime:", error);
      callback([]);
    }
  };

  return {
    time,
    getSelectedtimeText,
    selectall,
    clearselection,
    loadtime,
  };
}
