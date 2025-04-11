/** @format */

// DayDropdownLogic.js
export default function useDayDropdown() {
  const days = [
    { id: 1, name: "Monday", acro: "MON" },
    { id: 2, name: "Tuesday", acro: "TUE" },
    { id: 3, name: "Wednesday", acro: "WED" },
    { id: 4, name: "Thursday", acro: "THU" },
    { id: 5, name: "Friday", acro: "FRI" },
    { id: 6, name: "Saturday", acro: "SAT" },
    { id: 7, name: "Sunday", acro: "SUN" },
  ];

  const getSelectedDaysText = (selectedDays) => {
    if (selectedDays.length === days.length) {
      return "All Days";
    }
    if (selectedDays.length === 0) {
      return "Select Days";
    }
    return selectedDays
      .map((id) => {
        const day = days.find((d) => d.id === id);
        return day ? day.acro : "";
      })
      .join(", ");
  };

  const selectAll = (selectedDays) => {
    return days.map((day) => day.id);
  };

  const clearSelection = () => {
    return [];
  };

  const loadDays = (callback) => {
    // Simulate API call
    setTimeout(() => {
      callback();
    }, 500);
  };

  return {
    days,
    getSelectedDaysText,
    selectAll,
    clearSelection,
    loadDays,
  };
}
